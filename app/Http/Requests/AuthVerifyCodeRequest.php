<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthVerifyCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'string'],
            'code' => ['required', 'string', 'size:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'O campo de e-mail é obrigatório.',
            'email.email' => 'O campo de e-mail deve ser um endereço de e-mail válido.',
            'email.string' => 'O campo de e-mail deve ser uma string.',
            
            'code.required' => 'O campo de código é obrigatório.',
            'code.string' => 'O campo de código deve ser uma string.',
            'code.size' => 'O campo de código deve ter exatamente 5 caracteres.',
        ];
    }
}
