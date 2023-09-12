<?php

namespace App\ResponseHelper;

use App\ResponseHelper\AppResult;

use Symfony\Component\HttpFoundation\Response;

class SuccessfulResponse
{

    public static function respondSuccess($data = null, $status = 200): Response
    {
        $result = new AppResult(data: $data, success: true);
        return response()->json($result->getAsArray(), $status);
    }
}
