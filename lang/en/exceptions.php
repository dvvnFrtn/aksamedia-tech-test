<?php

return [
    '1001' => [
        'message' => 'Invalid credentials provided',
        'description' => 'The credentials provided do not match our records. Please check your username or password and try again'
    ],
    '1002' => [
        'message' => 'Token has expired',
        'description' => 'The provided token has expired. Please login again to get a new token'
    ],
    '1003' => [
        'message' => 'Token is missing',
        'description' => 'Please provide a valid token in the Authorization header'
    ],
    '1004' => [
        'message' => 'User already authenticated',
        'description'=> 'The user is already logged in. Please use the existing token or log out before attempting to log in again',
    ],
    '2001' => [
        'message' => 'Resource not found',
        'description' => 'The requested resource could not be found in our system'
    ]
];
