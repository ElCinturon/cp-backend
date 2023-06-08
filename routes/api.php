<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;

/*
 * |--------------------------------------------------------------------------
 * | API Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register API routes for your application. These
 * | routes are loaded by the RouteServiceProvider and all of them will
 * | be assigned to the "api" middleware group. Make something great!
 * |
 */

// Nur nutzen wenn user eingeloggt sein muss?
//Route::middleware('auth:sanctum')->

// Login
Route::post('/login', [
    LoginController::class,
    'authenticate'
]);


// Registrierung
Route::post('/registration', [
    RegistrationController::class,
    'register'
]);