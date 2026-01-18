<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',

            'role_id' => 'nullable|integer|exists:roles,id',

            'username' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore(optional($this->user)->id),
            ],

            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(optional($this->user)->id),
            ],

            'scope_id' => 'nullable|integer|exists:users,id',

            'password' => $this->user
                ? ['nullable', 'string', 'min:6']
                : ['required', 'string', 'min:6', 'confirmed'],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('users', 'phone')->ignore(optional($this->user)->id)
            ]
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'password.required' => 'Password is required',
            'password.confirmed' => 'Password confirmation does not match',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email has already been taken',
            'username.unique' => 'Username has already been taken',
            'role_id.exists' => 'Role does not exist',
            'password.min' => 'Password must be at least 6 characters',
            'password.confirmed' => 'Password confirmation does not match',

        ];
    }
}
