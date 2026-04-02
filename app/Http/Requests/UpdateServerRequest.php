<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServerRequest extends FormRequest
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
                'name'        => 'sometimes|string|max:255',
                'url'         => 'sometimes|string|max:255',
                'protocol_id' => 'sometimes|exists:protocols,id',
                'status_id'   => 'sometimes|exists:statuses,id',
                'description' => 'nullable|string',
                'ip_address'  => 'sometimes|ip',
                'port'        => 'sometimes|integer', // Fixed typo 'prot' -> 'port'
                'method'      => 'sometimes|string',
                'username'    => 'nullable|string',
                'password'    => 'nullable|string',
                'config'      => 'nullable|array',
            ];
    }
}
