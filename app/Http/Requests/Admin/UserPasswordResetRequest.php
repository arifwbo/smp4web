<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserPasswordResetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'password' => ['nullable', 'string', 'min:8'],
            'generate_password' => ['nullable', 'boolean'],
        ];
    }
}
