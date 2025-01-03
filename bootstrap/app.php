<?php

use App\Exceptions\ApplicationException;
use App\Exceptions\AuthException;
use App\Exceptions\ResourceException;
use App\Helpers\ApiResponse;
use App\Http\Middleware\EnsureGuest;
use App\Http\Middleware\ForceAcceptJson;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->prepend(ForceAcceptJson::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function(ValidationException $e) {
            return ApiResponse::validationError($e->errors());
        });

        $exceptions->render(function(NotFoundHttpException $e) {
            if ($e->getPrevious() instanceof ModelNotFoundException) {
                throw ResourceException::notFound();
            }
            throw ApplicationException::routeNotFound();
        });

        $exceptions->render(function(AuthenticationException $e, Request $request) {
            if (empty($request->header('Authorization'))) {
                throw AuthException::tokenMissing();
            }

            if (! Auth::guard('sanctum')->check()) {
                throw AuthException::tokenExpired();
            }
        });

        $exceptions->render(function(ApplicationException $e) {
            $code = $e->getInternalCode();
            return ApiResponse::error(
                $code->value,
                $e->getMessage(),
                $e->getDescription(),
                $e->getCode(),
            );
        });
    })->create();
