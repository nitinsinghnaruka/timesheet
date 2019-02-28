<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\Register;
use App\User;

class RegisterController extends Controller
{
    /**
     * Create a controller instance.
     * 
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Register.
     * 
     * @param   Register  $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function create(Register $request)
    {
        // Create account
        $user = User::create([
            'name'     => $request['name'],
            'email'    => $request['email'],
            'password' => bcrypt($request['password'])
        ]);
        //---------------
        if (! is_null($user)) {
            if (auth()->loginUsingId($user->id)) {
                $user = auth()->user();

                // Set response
                $response = [
                    'status'  => true,
                    'message' => 'Account created.',
                    'user'    => $user->makeHidden('id'),
                    'token'   => $user->createToken('SPA')->accessToken
                ];
                //-------------
            } else {
                // Set response
                $response = [
                    'status'  => false,
                    'message' => 'Account created but unable to login, Please try again from login page.'
                ];
                //-------------
            }
            //------------------
        } else {
            // Set response
            $response = [
                'status'  => false,
                'message' => 'Unable to create account, Please try again!'
            ];
            //-------------
        }

        return response()->json($response, 200);
    }
}
