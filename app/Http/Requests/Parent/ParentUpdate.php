<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\Qs;

class ParentUpdate extends FormRequest
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
            'father_name' => 'string|nullable|alpha',
            'mother_name' => 'string|nullable|alpha',
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
            'father_name' => 'Nama Ayah',
            'mother_name' => 'Nama Ibu',
            'father_job' => 'Pekerjaan Ayah',
            'mother_job' => 'Pekerjaan Ibu',
            'father_phone' => 'Nomor Telepon Ayah',
            'mother_phone' => 'Nomor Telepon Ibu',
            'father_salary' => 'Pemasukan Ayah',
            'mother_salary' => 'Pemasukan Ibu',
        ];
    }

    protected function getValidatorInstance()
    {
        $input = $this->all();

        $this->getInputSource()->replace($input);

        return parent::getValidatorInstance();
    }
}
