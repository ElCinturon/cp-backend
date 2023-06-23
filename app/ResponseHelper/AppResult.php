<?php

namespace App\ResponseHelper;


class AppResult
{

    public static function create($data = null, $error = null, $success = true): array
    {
        $result = ["data" => $data, "error" => $error, "success" => $success];
        return $result;
    }
}
