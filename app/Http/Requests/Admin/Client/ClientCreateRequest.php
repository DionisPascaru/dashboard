<?php

namespace App\Http\Requests\Admin\Client;

use App\Enums\Client\ClientFieldsEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Client create request.
 */
class ClientCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            ClientFieldsEnum::NAME => 'required',
            ClientFieldsEnum::EMAIL => 'unique:users|required',
            ClientFieldsEnum::PASSWORD => 'required'
        ];
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'message' => $validator->errors()->first(),
        ], 422));
    }
}
