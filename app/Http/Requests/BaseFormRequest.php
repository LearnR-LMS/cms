<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Log;

class BaseFormRequest extends FormRequest
{
    public function failedResponse($input, $errors)
    {
        Log::channel('validation')->error($input);
        Log::channel('validation')->error($errors);

        $errorsData = [
            'success' => false,
            'status_code' => 422,
            'app_code' => 0,
            'message' => 'Validation Failed',
            'data' => null,
            'errors' => $errors,
        ];

        throw new HttpResponseException(response()->json($errorsData, 422));
    }

    protected function failedValidation(Validator $validator)
    {
        $ex = new ValidationException($validator);
        $errors = $ex->errors();

        $input = $validator->attributes();
        $this->failedResponse($input, $errors);
    }
}
