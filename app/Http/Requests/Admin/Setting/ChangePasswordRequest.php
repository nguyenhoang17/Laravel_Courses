<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'current_password' => 'required',
            'new_password' => 'required|min:8|different:current_password',
            're_new_password' => 'required|same:new_password',
        ];
    }
    public function messages()
    {
        return [
            'new_password.different' => 'Mật khẩu mới không được giống với mật khẩu cũ',
            're_new_password.same' => 'Mật khẩu xác nhận không trùng khớp',
            'current_password.min' => ':attribute cần tối thiểu 8 kí tự',
            '*.required' => ':attribute không được để trống',
        ];
    }
    public function attributes()
    {
        return [
            'current_password' => 'Mật khẩu',
            'new_password' => 'Mật khẩu mới',
            're_new_password' => 'Xác nhận mật khẩu mới',
        ];
    }
}
