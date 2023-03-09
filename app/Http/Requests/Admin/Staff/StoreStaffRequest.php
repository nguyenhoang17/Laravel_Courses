<?php

namespace App\Http\Requests\Admin\Staff;

use Illuminate\Foundation\Http\FormRequest;

class StoreStaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'name'   => ['required','string','max: 255'],
            'email'  => ['required','email:rfc,dns','unique:staffs'],
            'address'=> ['required','string'],
            'phone'  => ['required','regex:/(0)[0-9]{9}/','digits:10','unique:staffs'],
            'gender' => ['required'],
        ];
    }
}
