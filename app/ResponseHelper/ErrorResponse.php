<?php

namespace App\ResponseHelper;

use App\ResponseHelper\AppResult;

use Symfony\Component\HttpFoundation\Response;

class ErrorResponse
{
    /* Gibt Antwort, die fehlerhafte Anfrage beantwortet.
       Wird als msg ein String übergeben, wird dieser in ein msg-Objekt gewrappt. Dies soll als allgemeiner Fehler der Anfrage 
       genutzt werden.
       Fehler die z.B. Inputfelder betreffen, sollten in einem array mit einem Key, benannt nach dem Json-Key der Anfrage, übergeben werden
    */
    public static function respondErrorMsg(array | string $msg = ['msg' => 'Es ist ein Fehler aufgetreten!'], $status = 200): Response
    {
        // Wenn String übergeben, diesen in Msg. Objekt setzen 
        $message = is_string($msg) ? ['msg' => $msg] : $msg;
        return response()->json(AppResult::create(error: $message, success: false), $status);
    }
}
