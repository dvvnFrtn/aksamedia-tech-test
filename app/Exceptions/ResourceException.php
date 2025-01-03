<?php

namespace App\Exceptions;

class ResourceException extends ApplicationException
{
    public static function notFound(): self
    {
        return static::new(ExceptionCode::NotFound);
    }
}