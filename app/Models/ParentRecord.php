<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParentRecord extends Eloquent
{

    use HasFactory;
    protected $fillable = [
        'father_name', 'mother_name', 'father_job', 'mother_job', 'father_phone', 'mother_phone', 'father_salary', 'mother_salary'
    ];

    public function fatherSalary()
    {
        return $this->belongsTo(SalaryType::class, 'father_salary', 'id');
    }
    
    public function motherSalary()
    {
        return $this->belongsTo(SalaryType::class, 'mother_salary', 'id');
    }
    

}
