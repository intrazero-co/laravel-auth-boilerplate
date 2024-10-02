<?php

namespace Intrazero\Authentication\Traits;

use Illuminate\Http\Request;
use Intrazero\Authentication\Services\AuthenticationManager;

trait LoginTrait
{
    /**
     * Handle user login.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Intrazero\Authentication\Services\AuthenticationManager $authManager
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, AuthenticationManager $authManager)
    {
        $loginField = config('authentication.login_field', 'email');
        $this->validateLogin($request, $loginField);

        if (!auth()->attempt([$loginField => $request->input($loginField), 'password' => $request->password])) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = auth()->user();
        $token = $authManager->createToken($user);

        return response()->json(['token' => $token], 200);
    }

    /**
     * Validate login data.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $loginField
     */
    protected function validateLogin(Request $request, $loginField)
    {
        $rules = config('authentication.login_validation', [
            'login_field' => 'required|string',
            'password' => 'required|string',
        ]);

        $rules[$loginField] = $rules['login_field'];
        unset($rules['login_field']);

        $request->validate($rules);
    }
}
