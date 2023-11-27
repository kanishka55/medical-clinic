<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email'=> 'required|email',
            'password'=> 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails())
        {
            return response()->json(['Validation Error.' => $validator->errors()], 422);
        }

        $input = $request->all();
        //$input ['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $sucess['token'] = $user->createToken('MyApp')->plainTextToken;
        $sucess['username'] = $user->username;

        return response()->json(['user registerd successfully' => $sucess], 200);
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email'=> $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['username'] = $user->username;

            return response()->json(['user login successfully' => $success], 200);
        }
        else{
            return response()->json(['Unauthorised.' => 'Unothorised user login'], 400);
        }
    }
}