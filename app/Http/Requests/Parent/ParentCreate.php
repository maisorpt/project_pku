<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\Qs;

class ParentCreate extends FormRequest
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
