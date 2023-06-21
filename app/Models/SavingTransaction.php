<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingTransaction extends Model
{
    protected $fillable = [
        'student_id',
        'student_saving_id',
        'amount',
        'transaction_type',
        'note'
    ];

    public function student()
    {
        return $this->belongsTo(StudentRecord::class);
    }

    public function student_saving()
    {
        return $this->belongsTo(StudentSaving::class);
    }
}
