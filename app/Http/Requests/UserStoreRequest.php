<?php

namespace App\Http\Requests;

class UserStoreRequest extends BaseFormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Vui lòng nhập Tên',
            'first_name.string' => 'Tên chỉ chứa chuỗi',
            'first_name.max' => 'Tên tối đa 255 ký tự',
            'last_name.required' => 'Vui lòng nhập Họ',
            'last_name.string' => 'Họ chỉ chứa chuỗi',
            'last_name.max' => 'Họ tối đa 255 ký tự',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng',
            'email.max' => 'Email tối đa 255 ký tự',
            'email.unique' => 'Email tồn tại',
            'email.string' => 'Email chỉ chứa chuỗi',
        ];
    }
}