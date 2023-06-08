<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentSaving extends Model
{
    protected $fillable = [
        'student_id',
        'balance',
    ];

    public function student()
    {
        return $this->belongsTo(StudentRecord::class);
    }

    public function transactions()
    {
        return $this->hasMany(SavingTransaction::class);
    }
}

