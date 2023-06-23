<?php

namespace App\ResponseHelper;

use App\ResponseHelper\AppResult;

use Symfony\Component\HttpFoundation\Response;

class ErrorResponse
{

    public static function respondErrorMsg(String $msg = "Es ist ein Fehler aufgetreten!", $status = 200): Response
    {
        return response()->json(AppResult::create(error: $msg, success: false), $status);
    }
}
