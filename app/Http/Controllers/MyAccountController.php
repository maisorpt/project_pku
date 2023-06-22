<?php

namespace App\Http\Controllers;


use App\Helpers\Qs;
use App\Http\Requests\UserChangePass;
use App\Http\Requests\UserUpdate;
use App\Repositories\LocationRepo;
use App\Repositories\UserRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MyAccountController extends Controller
{
    protected $user, $loc;

    public function __construct(UserRepo $user, LocationRepo $loc)
    {
        $this->user = $user;
        $this->loc = $loc;
    }

    public function edit_profile()
    {
        $d['my'] = Auth::user();
        $d['cities'] = $this->loc->getCities($d['my']->prov_id);
        $d['districts'] = $this->loc->getDistricts($d['my']->city_id);
        $d['subdistricts'] = $this->loc->getSubDistricts($d['my']->dis_id);
        $d['provinces'] = $this->loc->getAllProvinces();
        return view('pages.support_team.my_account', $d);
    }

    public function update_profile(UserUpdate $req)
    {
        $user = Auth::user();

        $d = $user->username ? $req->only(['email', 'phone', 'address', 'prov_id', 'city_id', 'dis_id', 'subdis_id']) : $req->only(['email', 'phone', 'address', 'username', 'prov_id', 'city_id', 'dis_id', 'subdis_id']);

        if(!$user->username && !$req->username && !$req->email){
            return back()->with('pop_error', __('msg.user_invalid'));
        }

        $user_type = $user->user_type;
        $code = $user->code;

        if($req->hasFile('photo')) {
            $photo = $req->file('photo');
            $f = Qs::getFileMetaData($photo);
            $f['name'] = 'photo.' . $f['ext'];
            $f['path'] = $photo->storeAs(Qs::getUploadPath($user_type).$code, $f['name']);
            $d['photo'] = asset('storage/' . $f['path']);
        }

        $this->user->update($user->id, $d);
        return back()->with('flash_success', __('msg.update_ok'));
    }

    public function change_pass(UserChangePass $req)
    {   
        if(Auth::user()->user_type == 'student') {
            return back()->with('flash_danger', __('Untuk ganti password harap hubungi Admin'));
        }
        $user_id = Auth::user()->id;
        $my_pass = Auth::user()->password;
        $old_pass = $req->current_password;
        $new_pass = $req->password;

        if(password_verify($old_pass, $my_pass)){
            $data['password'] = Hash::make($new_pass);
            $this->user->update($user_id, $data);
            return back()->with('flash_success', __('msg.p_reset'));
        }

        return back()->with('flash_danger', __('msg.p_reset_fail'));
    }

}
