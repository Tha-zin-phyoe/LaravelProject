<?php

use App\Http\Controllers\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTeamController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::apiResource('employees',EmployeeController::class);

//ADMIN SECTION
Route::post('admin/register',[AdminController::class,'register']);
Route::post('admin/login',[AdminAuthController::class,'login']);
Route::group(['prefix' => 'admin', 'middleware' => AdminAuthMiddleware::class], function () {
    Route::apiResource('/user/list/admin',AdminController::class);
    Route::post('/logout',[AdminAuthController::class,'logout']);
    Route::post('/password/update',[AdminController::class,'adminPasswordUpdate']);
});


// Project API
Route::apiResource('projects',ProjectController::class);
// Team API
Route::apiResource('teams',TeamController::class);

// Project Team API
Route::apiResource('projectsteam',ProjectTeamController::class);