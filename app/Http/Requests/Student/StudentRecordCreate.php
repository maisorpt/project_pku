<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\Qs;

class StudentRecordCreate extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:6|max:150',
            'username' => 'required|string|min:6|max:150|alpha_num',
            'adm_no' => 'sometimes|nullable|alpha_num|min:3|max:150|unique:student_records',
            'gender' => 'required|string',
            'year_admitted' => 'required|string',
            'photo' => 'sometimes|nullable|image|mimes:jpeg,gif,png,jpg|max:2048',
            'address' => 'required|string|min:6|max:120',
            'prov_id' => 'required',
            'city_id' => 'required',
            'dis_id' => 'required',
            'subdis_id' => 'required',
            'my_class_id' => 'required',
            'section_id' => 'required',
            'dorm_id' => 'sometimes|nullable',
            'father_name' => 'string|nullable',
            'mother_name' => 'string|nullable',
            'father_job' => 'string|nullable',
            'mother_job' => 'string|nullable',
            'father_phone' => 'string|nullable',
            'mother_phone' => 'string|nullable',
            'father_salary' => 'string|nullable',
            'mother_salary' => 'string|nullable',
        ];
    }

    public function attributes()
    {
        return  [
            'section_id' => 'Section',
            'prov_id' => 'Provinsi',
            'my_class_id' => 'Class',
            'dorm_id' => 'Asrama',
            'city_id' => 'Kota',
            'dis_id' => 'Kecamatan',
            'subdis_id' => 'Kelurahan / Desa',
            'father_name' => 'Nama',
            'mother_name' => 'Nama',
        ];
    }

    protected function getValidatorInstance()
    {
        $input = $this->all();

        $this->getInputSource()->replace($input);

        return parent::getValidatorInstance();
    }
}
