<?php

namespace App\Http\Requests\Efox;

use App\Http\Requests\BaseFormRequest;

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
            'adress' => 'string|max:255',
            'phone' => 'numeric|digits:10',
            'address_vallet' => 'string|max:255',
            'u_id' => 'required|numeric',
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
            'adress.string' => 'Địa chỉ không hợp lệ',
            'adress.string' => 'Địa chỉ tối đa 255 ký tự',
            'phone.numeric' => 'SDT không hợp lệ',
            'phone.digits' => 'SDT tối đa 10 số',
            'address_vallet.string' => 'Địa chỉ không hợp lệ',
            'address_vallet.string' => 'Địa chỉ tối đa 255 ký tự',
            'u_id.required' => 'id user không để trống',
            'u_id.numeric' => 'id user đúng định dạng',
        ];
    }

    
}