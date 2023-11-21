<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoggedUserDataController extends Controller
{
   public function getProfileDetails()
    {
        $user = Auth::user();

        // if ($user) {
        //     if ($user->isUser()) {
        //         // Logic for user profile details
        //         return response()->json(['data' => $user->userProfile()], 200);
        //     } elseif ($user->isAdmin()) {
        //         // Logic for admin profile details
        //         return response()->json(['data' => $user->adminProfile()], 200);
        //     } else {
        //         // Handle other user types if needed
        //         return response()->json(['error' => 'Unknown user type'], 403);
        //     }
        // } else {
        //     return response()->json(['error' => 'Unauthenticated'], 401);
        // }
    }
}
