<?php

namespace App\Http\Requests\Admin\Client;

use App\Enums\Client\ClientFiltersEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Clients search request.
 */
class ClientsSearchRequest extends FormRequest
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
            'filters.' . ClientFiltersEnum::NAME => 'nullable|string|max:50',
            'filters.' . ClientFiltersEnum::EMAIL => 'nullable|string',
            'filters.' . ClientFiltersEnum::DATE_FROM => 'nullable|string',
            'filters.' . ClientFiltersEnum::DATE_TILL => 'nullable|string',
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
