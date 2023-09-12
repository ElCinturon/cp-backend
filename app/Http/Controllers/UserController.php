<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\ResponseHelper\ErrorResponse;
use App\ResponseHelper\SuccessfulResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /* 
     * Wenn der angegebene Username existiert, wird ein Response mit Status 200 zurückgegeben.
	 * In der Route wird sich um Antwort bei nicht gefundenem Model wegen Binding gekümmert.
	 */
    public function exists(User $user): Response
    {
        $exists = false;
        if ($user) {
            $exists = true;
        }

        return SuccessfulResponse::respondSuccess(['userExists' => $exists]);
    }

    // Wenn Löschung von User selber kommt, entfernen
    public function delete(int $id): Response
    {
        // User abrufen
        $user = User::find($id);

        // Wenn gefundener User mit aktuellem Nutzer übereinstimmt, diesen löschen
        if ($user && $user->id == Auth::user()->id) {

            $user->delete();

            // Usersession entfernen
            auth('web')->logout();

            return SuccessfulResponse::respondSuccess();
        } else {
            return ErrorResponse::respondErrorMsg("Nutzer konnte nicht gefunden werden oder es fehlen Berechtigungen!");
        }
    }
}
