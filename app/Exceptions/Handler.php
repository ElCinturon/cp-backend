<?php

namespace App\Exceptions;

use App\ResponseHelper\ErrorResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use RuntimeException;
use Throwable;
use Illuminate\Http\Request;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Bei einer Exception wird hier der Response generiert
        $this->renderable(function (RuntimeException $e) {
            $msg = 'Es ist ein unbekannter Fehler aufgetreten!';
            if (config('app.debug')) {
                $msg = $msg . $e;
            }
            return ErrorResponse::respondErrorMsg($msg, 500);
        });
    }
}
