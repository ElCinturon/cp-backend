<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
        public function authenticate(Request $request): RedirectResponse
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
                error_log('user gefunden');
                $request->session()->regenerate();

                // TODO: Redirect muss noch angepasst werden
                return redirect()->intended('dashboard');
            }

            
            // TODO: Muss noch angepasst werden
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }
}
