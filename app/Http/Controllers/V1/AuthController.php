<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\RecoveryRequest;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $service
    )
    {
    }

    public function postRegister(RegisterRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->register($request->validated()),
            Response::HTTP_CREATED
        );
    }

    public function postLogin(LoginRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->authenticate($request->toDTO())
        );
    }

    public function postRecovery(RecoveryRequest $request): Response
    {
        $this->service->sendRecovery($request->validated());

        return response()->noContent();
    }

    public function getTokenValidation(
        Request $request,
        string  $token
    ): Response
    {
        try {
            $this->service->validateToken($token, $request->input('email'));
            return response()->noContent();
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }


    }
}
