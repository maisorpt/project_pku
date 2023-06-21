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
        return $this->belongsTo(StudentRecord::class, 'student_id', 'id');
    }

    public function transaction()
    {
        return $this->hasMany(SavingTransaction::class);
    }
}

