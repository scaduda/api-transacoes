<?php

namespace App\Http\Requests;

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
            'name' => 'required|string|max:255',
            'fantasy_name' => 'nullable|string|max:255',
            'type' => 'required|numeric|between:1,2',
            'register' => 'required|string|min:11',
            'email' => 'required|string',
            'password' => 'required|string|min:6',
            'balance' => 'required|numeric',
        ];
    }
}
