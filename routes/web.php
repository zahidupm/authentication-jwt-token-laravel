<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PromotionalMailController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (){
    return view('welcome');
});

// api routes
Route::post('/register', [UserController::class, 'index']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/send-otp', [UserController::class, 'sendOTPCode']);
Route::post('/verify-otp', [UserController::class, 'verifyOTPCode']);
Route::post('/reset-password', [UserController::class, 'resetPassword'])->middleware([TokenVerification::class]);

Route::get('/user-profile',[UserController::class,'userProfile'])->middleware([TokenVerification::class]);
Route::post('/user-update',[UserController::class,'updateProfile'])->middleware([TokenVerification::class]);
// userLogout
Route::get('logout', [UserController::class, 'logout']);

//page rroutes
Route::get('/userLogin', [UserController::class, 'loginPage']);
Route::get('/userRegister', [UserController::class, 'registrationPage']);
Route::get('/verifyOtp', [UserController::class, 'verifyOtpPage']);
Route::get('/sendOtp', [UserController::class, 'sendOtpPage']);
Route::get('/resetPass', [UserController::class, 'resetPasswordPage']);
Route::get('/dashboard', [DashboardController::class, 'dashboardPage']);

Route::get('/userProfile', [UserController::class, 'profilePage']);
Route::get('/categoryPage', [CategoryController::class, 'categoryPage']);

// catetory
Route::post('create-category', [CategoryController::class, 'categoryCreate']);
Route::get('list-category', [CategoryController::class, 'categoryList']);
Route::post('delete-category', [CategoryController::class, 'categoryDelete']);
Route::post('update-category', [CategoryController::class, 'categoryUpdate']);

Route::resource('customer', CustomerController::class);

Route::post( '/promotional/mail', [PromotionalMailController::class, 'sendPromotionMail'] )->name( 'promotion.mail' );
Route::get( '/promotional/mail', [PromotionalMailController::class, 'promotionPage'] )->name( 'promotion.page' );


