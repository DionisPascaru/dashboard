<?php

namespace App\Http\Requests\Admin\Organization;

use App\Enums\Organization\OrganizationFiltersEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Organization search request.
 */
class OrganizationsSearchRequest extends FormRequest
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
            'filters.' . OrganizationFiltersEnum::NAME => 'nullable|string|max:50',
            'filters.' . OrganizationFiltersEnum::EMAIL => 'nullable|string',
            'filters.' . OrganizationFiltersEnum::DATE_FROM => 'nullable|string',
            'filters.' . OrganizationFiltersEnum::DATE_TILL => 'nullable|string',
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
