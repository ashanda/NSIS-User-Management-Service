<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserLoginController extends Controller
{

    public function showLoginForm(){

        return view('auth/login');
    }

    public function userRegister(Request $request)
    {
        $request = $request->all();

        $validator = Validator::make($request,[
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $request['password'] = Hash::make($request['password']);

        User::create($request);

        return response()->json(['status' => true, 'message' => 'User successfully register.' ], 200);
    }

    public function userLogin(Request $request)
    {
        $input = $request->all();
        $vallidation = Validator::make($input,[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($vallidation->fails()){
            return response()->json(['error' => $vallidation->errors()],422);
        }

        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            
            $token = Auth::guard('user')->user()->createToken('MyApp')->accessToken;

             return response()->json([            
            'status' => 200,
            'token' => $token,
        ], 200);

        } else {

            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }

    }

    public function userDetails()
    {
        $user = Auth::guard('user-api')->user();

    if ($user) {
        // Debugging information
       // dd($user->token(), $user->token()->scopes);

        // Return user details
        return response()->json(['user' => $user], 200);
    } else {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }
    }






}
