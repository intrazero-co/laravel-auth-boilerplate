<?php

namespace Intrazero\Authentication\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intrazero\Authentication\Services\AuthenticationManager;

trait RegisterTrait
{
    /**
     * Handle user registration.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Intrazero\Authentication\Services\AuthenticationManager $authManager
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request, AuthenticationManager $authManager)
    {
        // Validate the registration request and get only validated data
        $validatedData = $this->validateRegistration($request);

        // Use the model specified in the config
        $model = app(config('authentication.model'));

        // Create the user with only the validated fields, adding additional fields like hashed password
        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = $model::create($validatedData);
        $token = $authManager->createToken($user, $request->password);



        return response()->json(['token' => $token], 201);
    }

    /**
     * Validate the registration request.
     *
     * @param \Illuminate\Http\Request $request
     */
    protected function validateRegistration(Request $request)
    {
        $rules = config('authentication.registration_validation');
       return  $request->validate($rules);
    }


}
