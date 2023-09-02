<?php

namespace App\Http\Controllers;

use App\ResponseHelper\ErrorResponse;
use App\ResponseHelper\SuccessfulResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function authenticate(Request $request): Response
    {
        // Übergeben Werte validieren
        $request->validate([
            'userIdentifier' => ['required'],
            'password' => ['required'],
            'stayLoggedIn' => ['boolean', 'nullable']
        ]);

        // Identifier auslesen und prüfen ob email oder User übergeben wurde
        $identifier = $request->input('userIdentifier');
        $identifierType = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Logindaten prüfen
        if (Auth::attempt([$identifierType => $identifier, 'password' => $request->input('password')], $request->input('stayLoggedIn'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Login erfolgreich Return Username
            return SuccessfulResponse::respondSuccess(["username" => $user->username, "id" => $user->id]);
        }

        // Login fehlgeschlagen.
        return ErrorResponse::respondErrorMsg('Der angegebene Nutzer existiert nicht oder das Passwort ist nicht korrekt.');
    }
}
