<?php

return [
    /**
     * The Eloquent model used for authentication.
     */
    'model' => env('AUTH_MODEL', App\Models\User::class),

    /**
     * The field used for login (email, username, etc.).
     */
    'login_field' => env('AUTH_LOGIN_FIELD', 'email'),

    /**
     * Validation rules for registration.
     */
    'registration_validation' => [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ],

    /**
     * Validation rules for login.
     */
    'login_validation' => [
        'email' => 'required|string',
        'password' => 'required|string',
    ],

    /**
     * Choose the authentication method: 'passport' or 'sanctum'.
     */
    'auth_method' => env('AUTH_METHOD', 'passport'),

    // OAuth client credentials for Passport
    'passport' => [
        'client_id' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_ID'),
        'client_secret' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET'),
    ],
];
