<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{

    public function register(Request $request): RedirectResponse
    {
        // Übergeben Werte validieren
        $request->validate([
            'username' => [
                'required'
            ],
            'name' => [
                'required'
            ],
            'last_name' => [
                'required'
            ],
            'email' => [
                'required',
                'email'
            ],
            'password' => [
                'required'
            ]
        ]);

        error_log(implode('.', $request->all()));
        
        foreach($request->all() as $key => $value) {
            error_log("$key is at $value");
        }
        
        $user = new User();
        $user->fill($request->all());

        $user->save();

        // TODO: Redirect muss noch angepasst werden
        return redirect()->intended('dashboard');

        // TODO: Muss noch angepasst werden
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ])->onlyInput('email');
    }
}
