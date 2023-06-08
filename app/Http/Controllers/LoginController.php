<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
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
                'stayLoggedIn' => ['boolean']
            ]);
            
            
            // Identifier auslesen und prüfen ob email oder User übergeben wurde
            $identifier = $request->input('userIdentifier');
            $identifierType = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';        
            
            // Logindaten prüfen
            if (Auth::attempt([$identifierType => $identifier, 'password' => $request->input('password')], $request->input('stayLoggedIn'))) {
                $request->session()->regenerate();

                // Login erfolgreich Return HTTP-Code 200
                return response('', 200);
            }

            
            // Login fehlgeschlagen. Return 401
            return response('Der angegebene Nutzer existiert nicht oder das Passwort ist nicht korrekt.', 401);
        }
}
