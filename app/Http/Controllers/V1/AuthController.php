<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Services\AuthService;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $service)
    {
    }

    public function postRegister(RegisterRequest $request)
    {
        return response()->json(
            $this->service->register($request->validated()),
            Response::HTTP_CREATED
        );
    }

    public function postLogin(LoginRequest $request)
    {
        return response()->json(
            $this->service->authenticate($request->toDTO())
        );
    }
}
