<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|email|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password' => 'required|min:8',
            're-password' => 'required|same:password',
            'phone' => 'required|unique:users|numeric|regex:/(0)[0-9]{9}/|digits:10',
        ];
    }
    public function messages()
    {
        return [
            'name.max' => ':attribute của bạn phải ít hơn 30 ký tự',
            '*.regex' => ':attribute sai định dạng',
            'email.email' => ':attribute sai định dạng',
            '*.unique' => ':attribute đã tồn tại',
            're-password.same' => ':attribute không trùng khớp',
            'password.min' => ':attribute cần tối thiểu 8 kí tự',
            'phone.digits' => ':attribute phải bao gồm 10 số',
            're-password.required' => ':attribute xác nhận không được để trống',
            '*.required' => ':attribute không được để trống',
            '*.numeric' => 'Vui lòng nhập :attribute là số',
        ];
    }
    public function attributes()
    {
        return [
            'email' => 'Email',
            'password' => 'Mật khẩu',
            're-password' => 'Mật khẩu',
            'phone' => 'SĐT',
            'name' => 'Tên',
        ];
    }
}
