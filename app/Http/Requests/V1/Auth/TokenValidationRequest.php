<?php

namespace App\Http\Requests\V1\Auth;

use App\DTO\Auth\TokenValidationDTO;
use Illuminate\Foundation\Http\FormRequest;

class TokenValidationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required'],
        ];
    }

    public function toDto(string $token): TokenValidationDTO
    {
        return new TokenValidationDTO(
            $token,
            $this->input('email')
        );
    }
}
