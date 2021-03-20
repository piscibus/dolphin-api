<?php

use App\Http\Controllers\Api\EmailRegistrationController;
use Illuminate\Support\Facades\Route;

Route::post('/registration/email', [EmailRegistrationController::class, 'store'])->name('emailRegistration');
