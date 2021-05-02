<?php

use App\Http\Controllers\Api\EmailLoginController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\MyProfileController;
use Illuminate\Routing\Router;
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

Route::middleware('auth:api')->group(function (Router $router) {
    $router->any('/logout', [EmailLoginController::class, 'destroy'])->name('logout');
    $router->post('/files', [FileController::class, 'store'])->name('files.store');
    $router->get('/profile', MyProfileController::class)->name('myProfile');
});
