<?php

namespace App\Exceptions;

use App\Helpers\ResponseHelper;
use BadMethodCallException;
use Error;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use InvalidArgumentException;
use ReflectionException;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;
use TypeError;

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
        $this->renderable(function (AuthenticationException|AccessDeniedHttpException $e, Request $request) {
            if ($request->is('api/*'))
                return ResponseHelper::error($e->getMessage(), null, 401);
        });

        $this->renderable(function (ValidationException $e, Request $request) {
            if ($request->is('api/*'))
                return ResponseHelper::error($e->getMessage(), $e->errors(), $e->status);
        });
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*'))
                return ResponseHelper::error($e->getMessage(), null, $e->getStatusCode());
        });
        $this->renderable(function (InvalidArgumentException|BadMethodCallException|TypeError|RouteNotFoundException|Error|RuntimeException|BindingResolutionException|ReflectionException $e, Request $request) {

            if ($request->is('api/*'))
                return ResponseHelper::error($e->getMessage(), null, 500);
        });
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
