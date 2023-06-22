<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Helpers\Mk;
use App\Http\Requests\Student\StudentRecordCreate;
use App\Http\Requests\Student\StudentRecordUpdate;
use App\Models\ParentRecord;
use App\Models\SavingTransaction;
use App\Models\StudentSaving;
use App\Repositories\LocationRepo;
use App\Repositories\MyClassRepo;
use App\Repositories\SavingRepo;
use App\Repositories\StudentRepo;
use App\Repositories\UserRepo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentRecordController extends Controller
{
    protected $loc, $my_class, $user, $student, $saving;

   public function __construct(LocationRepo $loc, MyClassRepo $my_class, UserRepo $user, StudentRepo $student, SavingRepo $saving)
   {
       $this->middleware('teamSA', ['only' => ['edit','update', 'reset_pass', 'create', 'store', 'graduated'] ]);
       $this->middleware('super_admin', ['only' => ['destroy',] ]);

        $this->loc = $loc;
        $this->my_class = $my_class;
        $this->user = $user;
        $this->student = $student;
        $this->saving = $saving;
   }

    public function reset_pass($st_id)
    {
        $st_id = Qs::decodeHash($st_id);
        $data['password'] = Hash::make('student');
        $this->user->update($st_id, $data);
        return back()->with('flash_success', __('msg.p_reset'));
    }

    public function create()
    {   
        $data['my_classes'] = $this->my_class->all();
        $data['dorms'] = $this->student->getAllDorms();
        $data['provinces'] = $this->loc->getAllProvinces();
        $data['salary_types'] = $this->student->getSalaryTypes();
        return view('pages.support_team.students.add', $data);
    }

    public function store(StudentRecordCreate $req)
    {
       $data =  $req->only(Qs::getUserRecord());
       $sr =  $req->only(Qs::getStudentData());
       $pr = $req->only(Qs::getParentData());

        $ct = $this->my_class->findTypeByClass($req->my_class_id)->code;

        $data['user_type'] = 'student';
        $data['name'] = ucwords($req->name);
        $data['code'] = strtoupper(Str::random(10));
        $data['password'] = Hash::make('student');
        $data['photo'] = Qs::getDefaultUserImage();
        $data['username'] = strtolower($req->username);

        if($req->hasFile('photo')) {
            $photo = $req->file('photo');
            $f = Qs::getFileMetaData($photo);
            $f['name'] = 'photo.' . $f['ext'];
            $f['path'] = $photo->storeAs(Qs::getUploadPath('student').$data['code'], $f['name']);
            $data['photo'] = asset('storage/' . $f['path']);
        }

        $adm_no = $req->adm_no;
        $sr['adm_no'] = strtoupper(Qs::getAppCode().'/'.$ct.'/'.$sr['year_admitted'].'/'.($adm_no ?: mt_rand(1000, 99999)));
        $sr['session'] = Qs::getSetting('current_session');

        DB::transaction(function () use ($data, $pr, $sr) {
            // Create User
            $user = $this->user->create($data);
        
            // Create Parent
            $parent = $this->student->createParent($pr);
        
            // Create Student
            $sr['user_id'] = $user->id;
            $sr['my_parent_id'] = $parent->id;

            $student = $this->student->createRecord($sr);
        
            // Create Saving Record
            $ss['student_id'] = $student->id;
            $this->saving->createRecord($ss);
        });
        return Qs::jsonStoreOk();
    }

    public function listByClass($class_id)
    {
        $data['my_class'] = $mc = $this->my_class->getMC(['id' => $class_id])->first();
        $data['students'] = $this->student->findStudentsByClass($class_id);
        $data['sections'] = $this->my_class->getClassSections($class_id);

        return is_null($mc) ? Qs::goWithDanger() : view('pages.support_team.students.list', $data);
    }

    public function graduated()
    {
        $data['my_classes'] = $this->my_class->all();
        $data['students'] = $this->student->allGradStudents();

        return view('pages.support_team.students.graduated', $data);
    }

    public function not_graduated($sr_id)
    {
        $d['grad'] = 0;
        $d['grad_date'] = NULL;
        $d['session'] = Qs::getSetting('current_session');
        $this->student->updateRecord($sr_id, $d);

        return back()->with('flash_success', __('msg.update_ok'));
    }

    public function show($sr_id)
    {
        $sr_id = Qs::decodeHash($sr_id);
        if(!$sr_id){return Qs::goWithDanger();}

        $data['sr'] = $this->student->getRecord(['id' => $sr_id])->first();
        /* Prevent Other Students/Parents from viewing Profile of others */
        if(Auth::user()->id != $data['sr']->user_id && !Qs::userIsTeamSAT() && !Qs::userIsMyChild($data['sr']->user_id, Auth::user()->id)){
            return redirect(route('dashboard'))->with('pop_error', __('msg.denied'));
        }

        return view('pages.support_team.students.show', $data);
    }

    public function edit($sr_id)
    {
        $sr_id = Qs::decodeHash($sr_id);
        if(!$sr_id){return Qs::goWithDanger();}

        $data['sr'] = $this->student->getRecord(['id' => $sr_id])->first();
        $data['my_classes'] = $this->my_class->all();
        $data['dorms'] = $this->student->getAllDorms();
        $data['cities'] = $this->loc->getCities($data['sr']->user->prov_id);
        $data['districts'] = $this->loc->getDistricts($data['sr']->user->city_id);
        $data['subdistricts'] = $this->loc->getSubDistricts($data['sr']->user->dis_id);
        $data['provinces'] = $this->loc->getAllProvinces();
        $data['salary_types'] = $this->student->getSalaryTypes();
        return view('pages.support_team.students.edit', $data);
    }

    public function update(StudentRecordUpdate $req, $sr_id)
    {   
        $sr_id = Qs::decodeHash($sr_id);
        if(!$sr_id){return Qs::goWithDanger();}
        $pr = $req->only(Qs::getParentData());

        $sr = $this->student->getRecord(['id' => $sr_id])->first();
        $d =  $req->only(Qs::getUserRecord());
        $d['name'] = ucwords($req->name);
        $d['username'] = strtolower($req->username);

        if($req->hasFile('photo')) {
            $photo = $req->file('photo');
            $f = Qs::getFileMetaData($photo);
            $f['name'] = 'photo.' . $f['ext'];
            $f['path'] = $photo->storeAs(Qs::getUploadPath('student').$sr->user->code, $f['name']);
            $d['photo'] = asset('storage/' . $f['path']);
        }

        $this->user->update($sr->user->id, $d); // Update User Details

        $srec = $req->only(Qs::getStudentData());

        $this->student->updateRecord($sr_id, $srec); // Update St Rec

        $this->student->updateParentRecord($sr->my_parent_id ,$pr); // Update Parent

        return Qs::jsonUpdateOk();
    }

    public function destroy($st_id)
    {
        $st_id = Qs::decodeHash($st_id);
        if (!$st_id) {
            return Qs::goWithDanger();
        }
    
        $studentRecord = $this->student->getRecord(['user_id' => $st_id])->first();

        if ($studentRecord) {
            $studentRecord->transactions()->delete();
            $studentRecord->savings()->delete();
            $studentRecord->parent()->delete();
            $studentRecord->delete();
        }
    
        // Hapus record student
        $this->user->delete($studentRecord->user->id);
    
        return back()->with('flash_success', __('msg.del_ok'));
    }
    

}
