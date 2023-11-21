<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\User;
use Illuminate\Http\Response;
class AdminLoginController extends Controller
{

    public function showLoginForm(){
     
        return view('auth/login');
    }

    public function adminLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if($validator->fails()){

            return response()->json(['error' => $validator->errors()->all()]);
        }

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $admin = Auth::guard('admin')->user();
            $token = Auth::guard('admin')->user()->createToken('MyApp')->accessToken;

             return response()->json([            
            'status' => 200,
            'token' => $token,
        ], 200);

        } else {

            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }

    }

    public function adminDashboard()
    {
        dd('mac');
        return response()->json(Auth::guard('admin')->user());
    }

    public function adminDetails()
    {
        $admin = Auth::guard('admin')->user();
        
        if ($admin) {
            return response()->json(['admin' => $admin]);
        } else {
            return response()->json(['error' => 'Admin not found'], 404);
        }
    }

            public function allUsers()
        {
            // Check if the user is authenticated with the 'admin-api' guard
            if (Auth::guard('admin-api')->check()) {
                // Check if the authenticated user has the 'admin' role
                if (Auth::guard('admin-api')->user()->token()) {
                    // User has the 'admin' role, proceed with fetching users
                    $users = User::all();
                    return response()->json(['users' => $users]);
                } else {
                    // User does not have the required role, return unauthorized
                    return response()->json(['error' => 'Unauthorized. Insufficient role.'], 403);
                }
            } else {
                // User is not authenticated, return unauthorized
                return response()->json(['error' => 'Unauthorized.'], 401);
            }
        }

    public function adminLogout(): Response
    {
        if(Auth::guard('admin-api')->check()){
            $accessToken = Auth::guard('admin-api')->user()->token();
           
                DB::table('oauth_refresh_tokens')
                    ->where('access_token_id', $accessToken->id)
                    ->update(['revoked' => true]);
            $accessToken->revoke();

            return Response(['data' => 'Unauthorized','message' => 'User logout successfully.'],200);
        }
        return Response(['data' => 'Unauthorized'],401);
    }
}
