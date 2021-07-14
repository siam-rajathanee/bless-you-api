<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonationController;
use App\Http\Middleware\Organization;
use Illuminate\Support\Facades\Route;

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

Route::group(
    [
        'prefix' => '/{organization}',
        'middleware' => [Organization::class],
    ],
    function () {
        Route::post('/donations', [DonationController::class, 'store']);

        Route::group([
            'prefix' => 'auth',
        ], function () {
            Route::post('/login', [AuthController::class, 'login']);
            Route::post('/register', [AuthController::class, 'register']);
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/refresh', [AuthController::class, 'refresh']);
            Route::get('/user-profile', [AuthController::class, 'userProfile']);
        });

        Route::group([
            // 'middleware' => 'auth:api',
        ], function () {
            Route::resource('/donations', DonationController::class);
        });
    }
);
