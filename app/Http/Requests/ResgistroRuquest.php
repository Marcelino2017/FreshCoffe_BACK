<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password AS PasswordRules;

class ResgistroRuquest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'  => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                PasswordRules::min(8)->letters()->symbols()->numbers()
            ],
        ];
    }

    public function messages()
    {
        return [
            'name' => 'El Nombre es obligatorio',
            'email.required' => 'El Email es obligatorio',
            'email.email' => 'El Email no es válido',
            'email.unique' => 'El usuario ya esta registrado',
            'password' => 'La confirmación del campo de contraseña no coincide. El campo de contraseña debe tener al menos 8 caracteres.'
        ];
    }
}
