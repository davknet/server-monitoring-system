<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreServerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

        'name'        => 'required|string|max:255',
        'url'         => 'required|string|max:255',
        'protocol_id' => 'required|exists:protocols,id',
        'description' => 'nullable|string',
        'config'      => 'nullable|array',

        ];
    }
}
