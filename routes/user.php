<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserLoginController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// UNAUTH API FOR USE LOGIN
Route::post('user/login',[UserLoginController::class, 'userLogin'])->name('user.login');


// AUTHENTICATION API FOR USE
Route::group( ['prefix' => 'user','middleware' => ['auth:user-api','scopes:user'] ],function(){
    
    Route::post('dashboard',[UserLoginController::class, 'userDashboard'])->name('user.dashboard');
    
    
}); 

 Route::get('user/profile-details',[UserLoginController::class,'userDetails']);
