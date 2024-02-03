<?php

namespace App\Http\Requests\V1\Auth;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\ResetPasswordDTO;
use App\DTO\Auth\TokenValidationDTO;
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

    public function toDto(): ResetPasswordDTO
    {
        $tokenDTO = new TokenValidationDTO(
            $this->input('token'),
            $this->input('email')
        );

        return new ResetPasswordDTO(
            tokenValidation: $tokenDTO,
            password: $this->input('password')
        );
    }

}
