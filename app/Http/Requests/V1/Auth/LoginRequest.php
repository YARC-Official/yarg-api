<?php

namespace App\Http\Requests\V1\Auth;

use App\DTO\Auth\LoginDTO;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'exists:users'],
            'password' => ['required'],
        ];
    }

    public function toDTO(): LoginDTO
    {
        return LoginDTO::fromRequest($this->validated());
    }
}
