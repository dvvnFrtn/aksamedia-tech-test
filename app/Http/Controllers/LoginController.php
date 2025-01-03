<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthException;
use App\Helpers\ApiResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        $validated = $request->validated();
        $isSuccess = Auth::attempt($validated);

        if (!$isSuccess) {
            throw AuthException::invalidCredentials();
        }

        $user = Auth::user();
        $expiration = Carbon::now()->addHours(1);
        $token = $user->createToken("access-token",['*'],$expiration);

        return ApiResponse::success([
            'token' => $token->plainTextToken,
            'expire_at' => $token->accessToken->expires_at,
            'admin' => new UserResource($user)
        ], "Authentication successful");
    }
}
