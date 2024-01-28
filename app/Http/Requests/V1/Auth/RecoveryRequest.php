<?php

namespace App\Http\Requests\V1\Auth;

use App\DTO\Auth\LoginDTO;
use Illuminate\Foundation\Http\FormRequest;

class RecoveryRequest extends FormRequest
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

    public function toDTO(): LoginDTO
    {
        return LoginDTO::fromRequest($this->validated());
    }
}
