<?php

namespace App\ResponseHelper;

class AppResult
{
    private array | string | null $data;
    private bool $success;
    private string | array | null $error;

    public function __construct($data = null, $error = null, $success = true)
    {
        // Todo: Hier nochmal gucken, ob das immer so funktioniert oder ob es einen besseren weg gibt.
        // Data kann verschiedener typ sein und es ist nicht sicher ob decode immer funktioniert
        $this->data = is_string($data) || is_object($data) ? json_decode($data, true) : $data;
        $this->error = $error;
        $this->success = $success;
    }

    // Gibt das AppResult als Array zurück
    public function getAsArray()
    {
        return get_object_vars($this);
    }
}
