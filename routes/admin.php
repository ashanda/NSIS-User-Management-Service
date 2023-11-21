<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;
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
Route::post('admin/login',[AdminLoginController::class, 'adminLogin'])->name('admin.login');

// AUTHENTICATION API FOR USE

Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin-api', 'scope:admin']], function () {
    //Route::post('user/register',[UserLoginController::class, 'userRegister'])->name('user.register');
    Route::get('dashboard',[AdminLoginController::class, 'adminDashboard'])->name('admin.dashboard');
    
     //Route::get('allUsers', [AdminLoginController::class, 'allUsers']);
}); 


Route::controller(AdminLoginController::class)->group(function(){
    
    Route::get('admin/profile-details','adminDetails');
    Route::get('allUsers','allUsers');
    Route::get('logout','adminLogout');

})->middleware('auth:admin-api');



 

 