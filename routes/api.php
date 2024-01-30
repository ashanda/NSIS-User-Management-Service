<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\FeesAutomateController;
use App\Http\Controllers\FeesCalculationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserActivityController;
use App\Http\Controllers\UserAssigningController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\MasterClassController;
use App\Http\Controllers\MasterGradeController;
use App\Http\Controllers\MasterExtracurricularController;
use App\Http\Controllers\MonthlyFeeController;
use App\Http\Controllers\StudentPaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YearClassGradeController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', [LoginController::class,'login']);
Route::post('/register', [RegisterController::class,'register']);


Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [ProfileController::class,'show']);
    Route::post('/logout', [ProfileController::class,'logout']);
    Route::get('/permissions', [PermissionController::class,'index']);
    
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/user_levels', UserLevelController::class);
    Route::apiResource('/user_roles', UserRoleController::class);
    Route::apiResource('/user_activities', UserActivityController::class);
    Route::apiResource('/user_assignees', UserAssigningController::class);
    Route::apiResource('/students', StudentController::class);
    Route::apiResource('/class', MasterClassController::class);
    Route::apiResource('/grade', MasterGradeController::class);
    Route::apiResource('/extra_curricular', MasterExtracurricularController::class);
    Route::apiResource('/year_grade_class', YearClassGradeController::class);
    
    Route::apiResource('/enrollments', EnrollmentController::class);
    // end point of calculation
    // Route::get('/generate_monthly_fee', [FeesAutomateController::class, 'monthly_fee']);
    Route::get('/generate_surcharge_fee', [FeesCalculationController::class, 'surcharge_fee']);
    // Route::get('/invoice_generate', [FeesAutomateController::class, 'invoice_generate']);

    Route::get('/user_single_invoice/{id}', [FeesCalculationController::class, 'user_payments']);

    Route::post('/user_payments', [FeesCalculationController::class, 'user_payment_update']);

    Route::get('/user_invoices', [FeesCalculationController::class, 'current_user_pay']);

    Route::post('/invoices', [InvoiceController::class, 'user_wise_invoices']);
    
    Route::post('/all_user_payments', [FeesCalculationController::class, 'all_user_payments']);

    Route::apiResource('/student_payments', StudentPaymentController::class);

    Route::get('/logged_user', [AuthController::class, 'logged_user']);


    //Reports
    Route::get('/student-lists',[UserController::class, 'student_lists']);
    
  

    
    
    
    
   
});

