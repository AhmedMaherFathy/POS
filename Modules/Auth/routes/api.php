<?php

use App\Mail\test;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/


    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    
    
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');


    // Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    //     info(3);
    // $request->fulfill();
    // return response()->json(['message' => 'Email successfully verified.']);
    // })->name('verification.verify');

    Route::get('/email/verify/{id}/{hash}', [AuthController::class , 'verify'])->name('verification.verify');

    Route::get('test', [AuthController::class, 'test'])->name('test');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::get('/send-mail',function(){
    Mail::to('ahmedmaher2test@gmail.com')
     ->send(new test());
});
