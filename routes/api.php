<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ResetPasswordController;
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

Route::get('/', function () {
    return \request()->json([
        'code'=>'200',
        'message'=>'Hi dev! Welcome to blog api.'
    ]);
});

//Auth route
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::post('password/email', [ResetPasswordController::class, 'sendResetLinkEmail']);
Route::post('password/reset', [ResetPasswordController::class, 'resetPassword']);

Route::controller(BlogController::class)->group(function () {
    Route::get('/posts', 'index');
    Route::get('/posts/{id}', 'show');
});

// Dashboard routes
Route::group(['middleware' => ['auth:api', 'role:admin,moderator'],
    'prefix' => 'admin', 'name' => 'admin.'],
    function () {
        //Route for admin resource. Allowed user group: admin, moderator
        Route::apiResources([
            'posts' => PostController::class,
        ]);

    });


