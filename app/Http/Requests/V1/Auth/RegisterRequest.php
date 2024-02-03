<?php

namespace App\Http\Requests\V1\Auth;

use App\DTO\Auth\RegistrationDTO;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'username' => ['required', 'unique:users'],
            'password' => ['required', 'confirmed'],
            'email' => ['required', 'unique:users'],
        ];
    }

    public function toDto(): RegistrationDTO
    {
        return RegistrationDTO::fromRequest($this->validated());
    }
}
