<?php

namespace App\Http\Requests\Admin\Client;

use App\Enums\Client\ClientFieldsEnum;
use App\Models\Client;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

/**
 * Client update request.
 */
class ClientUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            ClientFieldsEnum::NAME => ['required', 'string', 'max:255'],
            ClientFieldsEnum::EMAIL => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(Client::DQL_ALIAS, 'email')->ignore($this->route('client')),
            ],
            ClientFieldsEnum::PASSWORD => ['nullable', 'string', 'min:8'],
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
