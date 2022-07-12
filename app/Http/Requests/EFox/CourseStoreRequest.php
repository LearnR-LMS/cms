<?php

namespace App\Http\Requests\EFox;

use App\Http\Requests\BaseFormRequest;

class CourseStoreRequest extends BaseFormRequest
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
            'u_id' => 'required|numeric',
            'name' => 'required|string|max:255',
            'total_time_learning' => 'required|numeric',
            'total_question' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'u_id.required' => 'ID khóa học không để trống.',
            'u_id.numeric' => 'ID khóa học đúng định dạng.',
            'name.required' => 'Vui lòng nhập tên.',
            'name.string' => 'Tên chỉ chứa chuỗi.',
            'name.max' => 'Tên tối đa 255 ký tự.',
            'total_time_learning.required' => 'Thời lượng học không để trống.',
            'total_time_learning.numeric' => 'Thời lượng học không đúng định dạng.',
            'total_question.required' => 'Tổng số câu hỏi của khóa học không để trống.',
            'total_question.numeric' => 'Tổng số câu hỏi của khóa học không đúng định dạng.',
        ];
    }    
}