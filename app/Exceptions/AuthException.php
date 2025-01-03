<?php

namespace App\Exceptions;

class AuthException extends ApplicationException
{
    public static function invalidCredentials(): self
    {
        return static::new(ExceptionCode::InvalidCredential);
    }

    public static function alreadyAuth(): self
    {
        return static::new(ExceptionCode::AlreadyAuth);
    }

    public static function tokenMissing(): self
    {
        return static::new(ExceptionCode::TokenMissing);
    }

    public static function tokenExpired(): self
    {
        return static::new(ExceptionCode::TokenExpired);
    }
}
