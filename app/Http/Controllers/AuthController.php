<?php

namespace App\Http\Controllers;

use App\ResponseHelper\ErrorResponse;
use App\ResponseHelper\SuccessfulResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Notifications\ResetPassword;
use \Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
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

    // loggt User aus
    public function logout(): Response
    {
        // Usersession entfernen
        auth('web')->logout();

        return SuccessfulResponse::respondSuccess();
    }

    // Sendet PW-ResetLink an User
    public function sendPasswordResetLink(Request $request): Response
    {
        $request->validate([
            'userIdentifier' => ['required']
        ]);

        // Identifier auslesen und prüfen ob email oder User übergeben wurde
        $identifier = $request->input('userIdentifier');
        $identifierType = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Wenn Useridentifier, Email suchen
        if ($identifierType == 'username') {
            $identifier = User::find($identifier);

            if (!$identifier) {
                // User kann nicht gefunden werden - nichts tun!
                return SuccessfulResponse::respondSuccess();
            } else {
                $identifier = $identifier->email;
            }
        }
        $user = User::firstWhere('email', $identifier);

        // Token für User erzeugen
        $token = Password::createToken($user);

        // Email an User mit dem Resettoken senden
        $user->notify(new ResetPassword($token));

        return SuccessfulResponse::respondSuccess();
    }

    // Setzt Passwort zurück
    public function resetPassword(Request $request): Response
    {
        $request->validate([
            'userIdentifier' => 'required',
            'password' => 'required|min:8',
        ]);

        // Token abfragen
        if (!$request->has('resetToken')) {
            return ErrorResponse::respondErrorMsg('Die Anfrage entspricht nicht dem richtigen Format!');
        }
        $token = $request->resetToken;

        $identifier = $request->input('userIdentifier');
        $identifierType = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Wenn Useridentifier, Email suchen
        if ($identifierType == 'username') {
            $identifier = User::find($identifier);

            if (!$identifier) {
                // User kann nicht gefunden werden
                return ErrorResponse::respondErrorMsg('Der eingegebene Nutzer ist nicht korrekt!');
            } else {
                $identifier = $identifier->email;
            }
        }

        $user = User::firstWhere('email', $identifier);

        if (!$user) {
            return ErrorResponse::respondErrorMsg('Der eingegebene Nutzer ist nicht korrekt!');
        }

        // Prüfen, ob Token für User korrekt ist
        $tokenValid = Password::tokenExists($user, $token);

        // Wenn Token korrekt, neues Passwort setzen
        if ($tokenValid) {
            $user->password = Hash::make($request->password);

            // Ist das nötig?
            if ($user->remember_token) {
                $user->setRememberToken(Str::random(60));
            }
            $user->save();

            // Token löschen 
            Password::deleteToken($user);
        } else {
            return ErrorResponse::respondErrorMsg('Es ist ein Validierungsfehler aufgetreten. Bitte fordern Sie einen neuen Resetlink an!');
        }

        return SuccessfulResponse::respondSuccess();
    }
}
