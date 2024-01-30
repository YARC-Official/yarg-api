<?php

namespace App\Http\Requests\V1\Auth;

use App\DTO\Auth\LoginDTO;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => ['required', 'string'],
            'email' => ['required', 'exists:users'],
            'password' => ['required','confirmed'],
        ];
    }

}
