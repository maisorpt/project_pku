<?php

namespace App\Repositories;

use App\Models\SavingTransaction;
use App\Models\StudentSaving;
use Illuminate\Support\Collection;

class SavingRepo
{
    public function createRecord($data)
    {
        return StudentSaving::create($data);
    }

    public function getTransactions()
    {
        return SavingTransaction::all();
    }

    public function getStudentSavings()
    {
        return StudentSaving::all();
    }

    public function find($id)
    {
        return StudentSaving::find($id);
    }

    public function findByStudentId($id)
    {
        return StudentSaving::where(['student_id' => $id])->first();
    }

    public function update(array $where, array $data)
    {
        return StudentSaving::where($where)->update($data);
    }

    public function createTransaction($data)
    {
        return SavingTransaction::create($data);
    }

    public function findTransactionByStudentId($id)
    {
        return SavingTransaction::where(['student_id' => $id])->get();
    }

    public function filterTransactionsByDate($fromDate, $toDate, $studentId = null)
    {
        $query = SavingTransaction::whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate);
    
        if ($studentId !== null) {
            $query->where('student_id', $studentId);
        }
    
        return $query->get();
    }
    

    public function getTotalTransactionByType(Collection $transactions, string $type): int
    {
        return $transactions->where('transaction_type', $type)->count();
    }

    public function getTotalNominalByType(Collection $transactions, string $type): int
    {
        return $transactions->where('transaction_type', $type)->sum('amount');
    }

    public function getTotalNominalAllTransactions($transactions)
{
    $totalNominal = 0;

    foreach ($transactions as $transaction) {
        $totalNominal += $transaction->amount;
    }

    return $totalNominal;
}

public function getTotal(Collection $transactions)
{
    $total = new \stdClass();
    $total->totalNominalTransaksi = $this->getTotalNominalAllTransactions($transactions);
    $total->totalSimpan = $this->getTotalTransactionByType($transactions, 'Simpan');
    $total->totalAmbil = $this->getTotalTransactionByType($transactions, 'Ambil');
    $total->totalNominalSimpan = $this->getTotalNominalByType($transactions, 'Simpan');
    $total->totalNominalAmbil = $this->getTotalNominalByType($transactions, 'Ambil');
    
    return $total;
}

}