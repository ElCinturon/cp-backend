<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PortfolioController;
use App\ResponseHelper\ErrorResponse;

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

// User routes
Route::controller(UserController::class)->group(function () {

    Route::prefix('user')->group(function () {

        // User anhand von username abfragen. Wenn nicht existiert entsprechendes Json zurückgeben
        Route::get('username/exists/{user:username}', 'exists')
            ->missing(function () {
                return ErrorResponse::respondErrorMsg([
                    'userExists' => false
                ]);
            });

        // User anhand von Email abfragen. Wenn nicht existiert entsprechendes Json zurückgeben
        Route::get('email/exists/{user:email}', 'exists')
            ->missing(function () {
                return response()->json([
                    'userExists' => false
                ]);
            });
    });
});


// Portfolio routes
Route::prefix('portfolios')->middleware('auth:sanctum')->group(function () {
    // Alle Portfolios vom User abrufen
    Route::get('', [PortfolioController::class, 'getAll']);

    // Portfolio anhand von ID abrufen
    Route::get('{id}', [PortfolioController::class, 'getOneById'])->whereNumber('id');

    // Neues Portfolio speichern
    Route::post('', [PortfolioController::class, 'add']);

    // Portfolio updaten
    Route::put('{id}', [PortfolioController::class, 'edit']);

    // Portfolio löschen
    Route::delete('{id}', [PortfolioController::class, 'delete']);

    // Portfoliotypen abrufen
    Route::get('types', [PortfolioController::class, 'getAllTypes']);

    // Neuen Portfolioentry speichern
    Route::post('entry', [PortfolioController::class, 'addEntry']);

    // Portfolioentry löschen
    Route::delete('{portfolioId}/entries/{id}', [PortfolioController::class, 'deleteEntry']);

    // Alle Portfolioentries zu Portfolio abrufen
    Route::get('{id}/entries', [PortfolioController::class, 'getAllEntries']);

    // Einen Portfolioentry mit allen Values abrufen
    Route::get('{portfolioId}/entries/{id}', [PortfolioController::class, 'getEntry']);

    // Einen Portfolioentryvalue anlegen
    Route::post('{portfolioId}/entries/{id}/values', [PortfolioController::class, 'setValue']);

    // Einen Portfolioentryvalue löschen
    Route::delete('{portfolioId}/entries/{entryid}/values/{id}', [PortfolioController::class, 'deleteValue']);

    // Einen Portfolioentryvalue ändern
    Route::put('{portfolioId}/entries/{entryid}/values/{id}', [PortfolioController::class, 'editValue']);
});
