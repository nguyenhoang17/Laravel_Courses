<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffRequest extends FormRequest
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
            'name' => 'required|max:30',
            'gender' => 'required',
            'address' => 'required',
            'phone' => ['required',"unique:staffs,phone,$this->id",'numeric','regex:/(0)[0-9]{9}/','digits:10'],
        ];
    }
    public function messages()
    {
        return [
            'name.max' => ':attribute của bạn phải ít hơn 30 ký tự',
            '*.required' => ':attribute không được để trống',
            'phone.digits' => ':attribute phải bao gồm 10 số',
            '*.numeric' => 'Vui lòng nhập :attribute là số',
            '*.regex' => ':attribute sai định dạng',
            '*.unique' => ':attribute đã tồn tại',
        ];
    }
    public function attributes()
    {
        return [
            'gender' => 'Giới tính',
            'phone' => 'SĐT',
            'name' => 'Tên',
            'address' => 'Địa chỉ',
        ];
    }
}
