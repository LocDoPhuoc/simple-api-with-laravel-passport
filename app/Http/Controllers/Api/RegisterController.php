<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Validator;

class RegisterController extends BaseController
{
    public function register(Request $request) {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $response = [
            'name' => $user->name,
            'token' => $user->createToken('SimpleApi')->accessToken
        ];

        return $this->sendResponse($response, 'User registered successfully.');
    }
}
