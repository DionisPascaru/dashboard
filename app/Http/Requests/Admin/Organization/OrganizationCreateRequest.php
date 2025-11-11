<?php

namespace App\Http\Requests\Admin\Organization;

use App\Enums\Organization\OrganizationFieldsEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Organization create request.
 */
class OrganizationCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            OrganizationFieldsEnum::NAME => ['required', 'string', 'max:255'],
            OrganizationFieldsEnum::OWNER => ['required', 'integer', 'exists:clients,id'],
            OrganizationFieldsEnum::DESCRIPTION => ['nullable', 'string'],
            OrganizationFieldsEnum::EMAIL => ['email', 'max:255'],
            OrganizationFieldsEnum::PHONE => ['nullable', 'string', 'max:100'],
            OrganizationFieldsEnum::ADDRESS => ['nullable', 'string', 'max:255'],
            OrganizationFieldsEnum::LOGO => ['nullable', 'string', 'max:255'],
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
