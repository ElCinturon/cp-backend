<?php
namespace App\Http\Controllers;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    /* 
     * Wenn der angegebene Username existiert, wird ein Response mit Status 200 zurückgegeben.
	 * In der Route wird sich um Antwort bei nicht gefundenes Model wegen Binding gekümmert.
	 */
    public function exists(User $user): Response
    {
        $exists = false;
        if($user) {
            $exists = true;
        }
        
        return response()->json(['userExists' => $exists]);
    }
}
