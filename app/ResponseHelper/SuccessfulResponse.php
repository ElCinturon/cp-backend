<?php

namespace App\ResponseHelper;

use App\ResponseHelper\AppResult;

use Symfony\Component\HttpFoundation\Response;

class SuccessfulResponse
{

    public static function respondSuccess($data = null, $status = 200): Response
    {
        return response()->json(AppResult::create(data: $data, success: true), $status);
    }
}
