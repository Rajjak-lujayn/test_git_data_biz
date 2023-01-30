<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AllData;
use App\Http\Controllers\Varifications;
use App\Http\Controllers\Admin\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\ensureEmailRegistered;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Sending admin status of browser session
Route::get('/isAdmin', function(){
    if(Auth::check()){
        return response()->json(["isAdmin"=> true], 200);
    }else{
        return response()->json(["isAdmin"=> false], 200);
    }
});
Route::post("/recordExport", [AllData::class, 'recordExport'])->name('recordExport');
Route::get("/sendOptions", [AllData::class, 'sendOptions'])->name('sendOptions');
Route::post("/getData", [AllData::class, 'getData'])->name('getData');
Route::post("/userRegistration", [Varifications::class, 'userRegistration'])->name('userRegistration');

Route::middleware([ensureEmailRegistered::class])->group(function () {
    Route::post("/exportData", [AllData::class, 'exportData'])->name('exportData');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/importData', [AllData::class, 'importData'])->name("importData");
    Route::post('/users', [User::class, 'getAll'])->name("getAllUsers");
    Route::post('/gettracking', [User::class, 'getTracking'])->name("getTracking");
    Route::post('/actionUser', [User::class, 'actions'])->name("actions");
});