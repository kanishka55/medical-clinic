<?php

use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\RegisterController;
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
Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
//Route::resource('/patients', PatientController::class);
// Route::post('register',[RegisterController::class => 'register']);
// Route::post('login', [RegisterController::class, 'login'])->withoutMiddleware(['auth:sanctum']);

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('/patients', PatientController::class);
});