<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    public static function success(
        $data = null, 
        $message = null, 
        $code = Response::HTTP_OK
    )
    {
        return response()->json(array_merge([
            'status' => 'success',
            'message' => $message,
        ], $data !== null ? ['data' => $data] : []), $code);
    }

    public static function error(
        $exCode, 
        $message, 
        $description, 
        $code = Response::HTTP_BAD_REQUEST
    )
    {
        return response()->json([
            'status' => 'error',
            'code' => $exCode,
            'message' => $message,
            'description' => $description,
        ], $code);
    }

    public static function validationError($errors)
    {
        return response()->json([
            'status' => 'error',
            'message' => 'The request payload contains failed validation',
            'errors' => $errors
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
