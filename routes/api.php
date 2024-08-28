<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PermissionController;

use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TenantController;
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

Route::post("login",[AuthController::class,'login']);


Route::middleware("auth:api")->group(function(){
    Route::get("/me",[AuthController::class,'me']);
    Route::post("logout",[AuthController::class,'logout']);
    Route::post("refresh",[AuthController::class,'refresh']);
    Route::apiResource('properties',PropertyController::class);
    Route::post("properties/{property}",[PropertyController::class,'update']);
    Route::apiResource("tenants",TenantController::class);
    Route::post("tenants/{tenant}",[TenantController::class,'update']);
    Route::apiResource("payments",PaymentController ::class);
    Route::post("payments/{payment}",[PaymentController::class,'update']);
   });

//users
