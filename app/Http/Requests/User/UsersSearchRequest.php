<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UsersSearchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'filters' => 'filled',
            'filters.name' => 'nullable|string|max:50',
            'filters.email' => 'nullable|string',
            'filters.role_id' => 'nullable|int',
            'filters.date_from' => 'nullable|string',
            'filters.date_till' => 'nullable|string',
            'pageSize' => 'int',
            'pageNum' => 'int'
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'message' => $validator->errors()->first(),
        ], 422));
    }
}
