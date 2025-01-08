<?php

//rename SystemName and ApiController
use App\Http\Controllers\SystemName\SystemRouteController ;
use App\Http\Controllers\LMS\LMSRouteController ;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AuthController;

//these routes are account related functions
Route::post('login', [AuthController::class, 'login']);
Route::post('otp-verification', [AuthController::class, 'otpVerification']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::middleware(['jwt', 'user-permission'])->group(function ()
{
    Route::post('permission',[PermissionController::class,'insertUserPermission']);
    Route::get('permission/{id?}',[PermissionController::class,'viewUserPermission']);
});

// Call the RouteController to register its routes
SystemRouteController::registerRoutes();
LMSRouteController::registerRoutes();

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
