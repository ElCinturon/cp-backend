<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
use Symfony\Component\HttpFoundation\Response;

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
// Route::middleware('auth:sanctum')->

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

Route::controller(UserController::class)->group(function () {

    Route::prefix('user')->group(function () {

        // User anhand von username abfragen. Wenn nicht existiert entsprechendes Json zurückgeben
        Route::get('username/exists/{user:username}', 'exists')->missing(function ($request) {
            return response()->json([
                'userExists' => false
            ]);
        });

        // User anhand von Email abfragen. Wenn nicht existiert entsprechendes Json zurückgeben
        Route::get('email/exists/{user:email}', 'exists')->missing(function ($request) {
            return response()->json([
                'userExists' => false
            ]);
        });
    });
});

