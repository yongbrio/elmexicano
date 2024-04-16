<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'lowercase', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.max' => 'El nombre no debe ser mayor a 255 caracteres.',
            'username.required' => 'El campo nombre de usuario es obligatorio.',
            'username.lowercase' => 'El nombre de usuario debe estar en minúsculas.',
            'username.max' => 'El nombre de usuario no debe ser mayor a 255 caracteres.',
            'username.unique' => 'El nombre de usuario ya está en uso.',
        ];
    }
}
