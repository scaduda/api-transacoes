<?php

namespace App\Http\Requests;

use App\Rules\FullName;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required|string|max:255', new FullName],
            'fantasy_name' => 'nullable|string|max:255',
            'type' => 'required|numeric|between:1,2',
            'register' => 'required|string|unique:usuarios,cadastro',
            'email' => 'required|string|unique:usuarios,email',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'type.required' => 'O campo tipo é obrigatório',
            'register.required' => 'O campo CPF/CNPJ é obrigatório',
            'email.required' => 'O campo email é obrigatório',
            'password.required' => 'O campo senha é obrigatório',
        ];
    }
}
