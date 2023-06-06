<?php

namespace App;

use App\Models\BloodGroup;
use App\Models\City;
use App\Models\District;
use App\Models\Lga;
use App\Models\Nationality;
use App\Models\Province;
use App\Models\StaffRecord;
use App\Models\State;
use App\Models\StudentRecord;
use App\Models\SubDistrict;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'dob', 'gender', 'photo', 'address', 'password', 'prov_id', 'city_id', 'dis_id', 'subdis_id', 'pob', 'code', 'user_type', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function student_record()
    {
        return $this->hasOne(StudentRecord::class);
    }


    public function province()
    {
        return $this->belongsTo(Province::class, 'prov_id', 'prov_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'dis_id', 'dis_id');
    }

    public function subdistrict()
    {
        return $this->belongsTo(SubDistrict::class, 'subdis_id', 'subdis_id');
    }

    public function staff()
    {
        return $this->hasMany(StaffRecord::class);
    }
}
