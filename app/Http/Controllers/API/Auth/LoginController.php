<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\Login;

class LoginController extends Controller
{
    /**
     * Authenticate user.
     * 
     * @param   Login  $request
     * @return 
     */
    public function authenticate(Login $request)
    {
        // Authenticate user.
        if (auth()->attempt([
            'email'    => $request['email'],
            'password' => $request['password']
        ])) {
            $user = auth()->user();

            // Set response.
            $response = [
                'status'  => true,
                'message' => 'Login successfully.',
                'user'  => $user->makeHidden('id'),
                'token' => $user->createToken('SPA')->accessToken
            ];
        } else {
            // Set response.
            $response = [
                'status'  => false,
                'message' => 'Username or Password incorrect, Please try again!'
            ];
        }

        return response()->json($response, 200);
    }
}
