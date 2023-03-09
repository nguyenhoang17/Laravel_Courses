<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegisterRequest extends FormRequest
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
            'name' => 'required|min:5|max:60',
            'email' => 'email|unique:users',
            'password' => 'required|min:6|max:50',
            'enterpass' => 'required:password|same:password|min:6|max:50',
            'phone' => 'required|digits_between:10,11|regex:/(0)[0-9]{9}/',
            'gender' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => ':attribute không được để trống .',
            'name.min' => ':attribute quá ngắn .',
            'name.max' => ':attribute quá dài .',

            'email.email' => ':attribute sai định dạng (ex : example@abc.com) .',
            'email.unique' => ':attribute đã được đăng kí .',

            'password.required' => ':attribute không được để trống .',
            'password.min' => ':attribute quá ngắn .',
            'password.max' => ':attribute quá dài .',

            'enterpass.required' => ':attribute không được để trống .',
            'enterpass.min' => ':attribute quá ngắn .',
            'enterpass.max' => ':attribute quá dài .',
            'enterpass.same' => ':attribute không đúng .',

            'phone.required' => ':attribute không được để trống .',
            'phone.digits_between' => ':attribute sai định dạng .',
            'phone.regex' => ':attribute phải bắt đầu bằng số 0 .',

            'gender.required' => ':attribute chưa được chọn .',
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'Tên',
            'email' => 'Email',
            'password' => 'Mật khẩu',
            'phone' => 'Số điện thoại',
            'gender' => 'Giới tính',
            'enterpass' => 'Mật khẩu xác nhận',
        ];
    }
}
