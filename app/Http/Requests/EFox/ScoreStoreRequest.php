<?php

namespace App\Http\Requests\EFox;

use App\Http\Requests\BaseFormRequest;

class ScoreStoreRequest extends BaseFormRequest
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
            'user_id' => 'required',
            'course_id' => 'required',
            'score' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'User ID bắt buộc.',
            'course_id.required' => 'ID khóa học bắt buộc.',
            'score.required' => 'Số điểm bắt buộc.',
            'score.required' => 'Số điểm phải kiểu số.',
        ];
    }    
}