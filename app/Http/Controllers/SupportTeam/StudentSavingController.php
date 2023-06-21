<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Http\Controllers\Controller;
use App\Http\Requests\Saving\SavingUpdate;
use App\Models\StudentSaving;
use App\Models\SavingTransaction;
use App\Repositories\MyClassRepo;
use App\Repositories\SavingRepo;
use App\Repositories\StudentRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentSavingController extends Controller
{
    protected $saving, $student, $my_class;

    public function __construct(SavingRepo $saving, StudentRepo $student, MyClassRepo $my_class)
    {   
        $this->middleware('teamSA', ['only' => ['edit','update', 'reset_pass', 'create', 'store', 'graduated'] ]);
        $this->middleware('super_admin', ['only' => ['destroy',] ]);

        $this->saving = $saving;
        $this->student = $student;
        $this->my_class = $my_class;
    }

    public function index()
    {

        $d['savings'] = $this->saving->getStudentSavings();
        $d['classes'] = $this->my_class->All();
        $d['sections'] = $this->my_class->getAllSections();

        return view('pages.support_team.savings.index', $d);
    }

    public function transactions(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        if ($fromDate && $toDate) {
            $d['transactions'] = $this->saving->filterTransactionsByDate($fromDate, $toDate);
            $d['total'] = $this->saving->getTotal($d['transactions']);

            return view('pages.support_team.savings.transactions', $d);
        }

        $d['transactions'] = $this->saving->getTransactions();

        $d['total'] = $this->saving->getTotal($d['transactions']);

        return view('pages.support_team.savings.transactions', $d);
    }

    public function show(Request $request, $saving)
    {   
        $sr_id = Qs::decodeHash($saving);
        if(!$sr_id){return Qs::goWithDanger();}

        $data['sr'] = $this->student->getRecord(['id' => $sr_id])->first();
        if(Auth::user()->id != $data['sr']->user_id && !Qs::userIsTeamSAT() && !Qs::userIsMyChild($data['sr']->user_id, Auth::user()->id)){
            return redirect(route('dashboard'))->with('pop_error', __('Alamat yang dituju tidak ditemukan'));
        }

        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        if ($fromDate && $toDate) {
            $d['student_id'] =  $sr_id;
            $d['transactions'] = $this->saving->filterTransactionsByDate($fromDate, $toDate,  $sr_id);

            $d['total'] = $this->saving->getTotal($d['transactions']);

            return view('pages.support_team.savings.transaction', $d);
        }  
            $d['student_id'] = Qs::decodeHash($saving);

            $d['transactions'] = $this->saving->findTransactionByStudentId($sr_id);

            $d['total'] = $this->saving->getTotal($d['transactions']);

            return view('pages.support_team.savings.transaction', $d);
    }

    public function edit($saving)
    {   
        $sr_id = Qs::decodeHash($saving);
        if(!$sr_id){return Qs::goWithDanger();}
        $d['saving'] = $this->saving->findByStudentId($sr_id);

        return view('pages.support_team.savings.edit', $d);
    }

    public function transaction($s_id, SavingUpdate $req)
    {
        $data = [];
        $s = $this->saving->findByStudentId($s_id);
        $d = $req->only(Qs::getTransactionData());

        $amount = str_replace('.', '', $req->amount);
        $d['amount'] = intval($amount);
        $d['student_id'] = $s_id;
        $d['student_saving_id'] = $s->id;

        if ($req->transaction_type == 'Ambil') {
            if ($s->balance >= $d['amount']) {
                $data['balance'] = $s->balance - $d['amount'];
            } else {
                return Qs::jsonLackBalance();
            }
        } else {
            $data['balance'] = $s->balance + $d['amount'];
        }

        $this->saving->createTransaction($d);
        $this->saving->update(['student_id' => $s_id], $data);
        return Qs::jsonTrasanctionSucces();
    }



    // public function create()
    // {
    //     return view('student_savings.create');
    // }

    // public function store(Request $request)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'amount' => 'required|numeric|min:0',
    //         'transaction_type' => 'required|in:deposit,withdraw',
    //     ]);

    //     // Ambil data dari request
    //     $amount = $request->input('amount');
    //     $transactionType = $request->input('transaction_type');

    //     // Mendapatkan user_id siswa yang sedang login
    //     $studentId = Auth::user()->id;

    //     // Buat transaksi tabungan
    //     $transaction = new SavingTransaction();
    //     $transaction->student_id = $studentId;
    //     $transaction->amount = $amount;
    //     $transaction->type = $transactionType;
    //     $transaction->save();

    //     // Update saldo tabungan siswa
    //     $studentSaving = StudentSaving::where('student_id', $studentId)->first();
    //     if (!$studentSaving) {
    //         // Jika belum ada data tabungan siswa, buat baru
    //         $studentSaving = new StudentSaving();
    //         $studentSaving->student_id = $studentId;
    //         $studentSaving->balance = $amount;
    //     } else {
    //         // Jika sudah ada data tabungan siswa, update saldo
    //         if ($transactionType === 'deposit') {
    //             $studentSaving->balance += $amount;
    //         } else {
    //             $studentSaving->balance -= $amount;
    //         }
    //     }
    //     $studentSaving->save();

    //     return redirect()->route('student_savings.index')->with('success', 'Transaksi tabungan berhasil.');
    // }

    // public function show($id)
    // {
    //     // Mendapatkan user_id siswa yang sedang login
    //     $studentId = Auth::user()->id;

    //     // Cek apakah transaksi dimiliki oleh siswa yang sedang login
    //     $transaction = SavingTransaction::where('id', $id)
    //         ->where('student_id', $studentId)
    //         ->first();

    //     if (!$transaction) {
    //         return redirect()->route('student_savings.index')->with('error', 'Transaksi tidak ditemukan.');
    //     }

    //     return view('student_savings.show', compact('transaction'));
    // }

    // public function edit($id)
    // {
    //     // Mendapatkan user_id siswa yang sedang login
    //     $studentId = Auth::user()->id;

    //     // Cek apakah transaksi dimiliki oleh siswa yang sedang login
    //     $transaction = SavingTransaction::where('id', $id)
    //         ->where('student_id', $studentId)
    //         ->first();

    //     if (!$transaction) {
    //         return redirect()->route('student_savings.index')->with('error', 'Transaksi tidak ditemukan.');
    //     }

    //     return view('student_savings.edit', compact('transaction'));
    // }

    // public function update(Request $request, $id)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'amount' => 'required|numeric|min:0',
    //         'transaction_type' => 'required|in:deposit,withdraw',
    //     ]);

    //     // Mendapatkan user_id siswa yang sedang login
    //     $studentId = Auth::user()->id;

    //     // Cek apakah transaksi dimiliki oleh siswa yang sedang login
    //     $transaction = SavingTransaction::where('id', $id)
    //         ->where('student_id', $studentId)
    //         ->first();

    //     if (!$transaction) {
    //         return redirect()->route('student_savings.index')->with('error', 'Transaksi tidak ditemukan.');
    //     }

    //     // Ambil data dari request
    //     $amount = $request->input('amount');
    //     $transactionType = $request->input('transaction_type');

    //     // Update transaksi tabungan
    //     $transaction->amount = $amount;
    //     $transaction->type = $transactionType;
    //     $transaction->save();

    //     // Update saldo tabungan siswa jika perubahan terjadi pada jenis transaksi
    //     $studentSaving = StudentSaving::where('student_id', $studentId)->first();
    //     if ($transaction->type !== $transactionType) {
    //         if ($transactionType === 'deposit') {
    //             $studentSaving->balance += $amount;
    //             $studentSaving->balance -= $transaction->amount;
    //         } else {
    //             $studentSaving->balance -= $amount;
    //             $studentSaving->balance += $transaction->amount;
    //         }
    //     }
    //     $studentSaving->save();

    //     return redirect()->route('student_savings.index')->with('success', 'Transaksi tabungan berhasil diupdate.');
    // }

    // public function destroy($id)
    // {
    //     // Mendapatkan user_id siswa yang sedang login
    //     $studentId = Auth::user()->id;

    //     // Cek apakah transaksi dimiliki oleh siswa yang sedang login
    //     $transaction = SavingTransaction::where('id', $id)
    //         ->where('student_id', $studentId)
    //         ->first();

    //     if (!$transaction) {
    //         return redirect()->route('student_savings.index')->with('error', 'Transaksi tidak ditemukan.');
    //     }

    //     // Hapus transaksi tabungan
    //     $transaction->delete();

    //     // Update saldo tabungan siswa
    //     $studentSaving = StudentSaving::where('student_id', $studentId)->first();
    //     if ($transaction->type === 'deposit') {
    //         $studentSaving->balance -= $transaction->amount;
    //     } else {
    //         $studentSaving->balance += $transaction->amount;
    //     }
    //     $studentSaving->save();

    //     return redirect()->route('student_savings.index')->with('success', 'Transaksi tabungan berhasil dihapus.');
    // }
}