<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Middleware\ensureEmailRegistered;
use App\Http\Controllers\Varifications;
use App\Http\Controllers\EmailController;
use App\Models\Tld_Domain_List;
use App\Models\User_Varification;
use App\Models\Register_User;

Route::get('/', function () {
    // $details = [
    //     'title' => 'Mail from DataBizprospex.com',
    //     'body' => 'This is for testing email using smtp'
    // ];
    // // akram.shekh.lujayninfoways@gmail.com
    // \Mail::to('nitesh.pandit.lujayninfoways@gmail.com')->send(new \App\Mail\SentEmail($details));
    return view('welcome');
})->name('home');

Route::get('varification/{slug}', [Varifications::class,'varifyEmail']);

Route::get('/get-csrf-token', function (){
    return csrf_token();
});

Route::post('/adminRegistration', [Varifications::class,'adminRegistration']);
Route::post('/adminLogin', [Varifications::class,'adminLogin']);

// Test Emai or SMTP Here
Route::get('/sendmail', function () {
   echo "test";
   dd("Email is Sent.");
   exit;
    $details = [
        'title' => 'Mail from DataBizprospex.com',
        'body' => 'This is for testing email using smtp'
    ];
   
    \Mail::to('akram.shekh.lujayninfoways@gmail.com')->send(new \App\Mail\SentEmail($details));
   
   
});
Route::get('/test', function () {
     $details = [
         'title' => 'Mail from DataBizprospex.com',
         'body' => 'This is for testing email using smtp'
     ];
    
     \Mail::to('akram.shekh.lujayninfoways@gmail.com')->send(new \App\Mail\SentEmail($details));
    
    
 });

Route::get('/signup', function(){

    return view('admin.signup');
});

Route::get('/login', function () {
    return view('admin.login');
})->name('login');
Route::get('/contact', [EmailController::class,'index']);
Route::post('/sendemail/send', [EmailController::class,'send']);

// Only Admin can visit this pages
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', function () {
            return view('admin/home');
        })->name("dashboard");
    
        Route::get('/file-upload', function () {
            return view('admin/home');
        });
    });
});