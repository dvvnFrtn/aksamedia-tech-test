<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

enum ExceptionCode: int
{
    case InvalidCredential  = 1001;
    case TokenExpired       = 1002;
    case TokenMissing       = 1003;
    case AlreadyAuth        = 1004;
    case RateLimitExceeded  = 1299;
    case NotFound           = 2001;

    public function getStatusCode(): int
    {
        $value = $this->value;
        return match(true) {
            $value >= 1001 && $value <= 1010 => Response::HTTP_UNAUTHORIZED,
            $value == 1299 => Response::HTTP_TOO_MANY_REQUESTS,
            $value == 2001 => Response::HTTP_NOT_FOUND,
            default => Response::HTTP_INTERNAL_SERVER_ERROR
        };
    }

    public function getMessage(): string
    {
        $key = "exceptions.{$this->value}.message";
        $transalation = __($key);

        if ($key === $transalation) {
            return "Something went wrong";
        }

        return $transalation;
    }

    public function getDescription(): string
    {
        $key = "exceptions.{$this->value}.description";
        $transalation = __($key);

        if ($key === $transalation) {
            return "Something went wrong";
        }

        return $transalation;
    }
}
