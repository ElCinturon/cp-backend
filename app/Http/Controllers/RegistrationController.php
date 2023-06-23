<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\ResponseHelper\ErrorResponse;
use App\ResponseHelper\SuccessfulResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{

    public function register(Request $request): Response
    {
        // Übergebene Werte validieren
        $request->validate([
            'username' => [
                'required'
            ],
            'name' => [
                'required'
            ],
            'lastName' => [
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

        $user = new User();
        $user->fill($request->all());

        $saved = $user->save();

        // Wenn User erfolgreich angelegt, 201 zurückgeben. Sonst Fehler.
        if ($saved) {
            return SuccessfulResponse::respondSuccess(['username' => $user->username], 201);
        } else {
            return ErrorResponse::respondErrorMsg('Bei der Registrierung ist ein Fehler aufgetreten');
        }
    }
}
