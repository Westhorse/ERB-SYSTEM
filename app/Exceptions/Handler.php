<?php

namespace App\Exceptions;

use Throwable;
use App\Helpers\JsonResponse;
use App\Helpers\ResponseStatus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (MethodNotAllowedHttpException $exception, $request) {
            return JsonResponse::respondError(trans(JsonResponse::MSG_NOT_ALLOWED), ResponseStatus::NOT_ALLOWED);
        });
        // $this->renderable(function (HttpException $exception, $request) {
        //     return JsonResponse::respondError(trans(JsonResponse::MSG_NOT_ALLOWED), ResponseStatus::BAD_REQUEST);
        // });
        $this->renderable(function (NotFoundHttpException $exception, $request) {
            return JsonResponse::respondError(trans(JsonResponse::MSG_NOT_FOUND), ResponseStatus::NOT_FOUND);
        });
        $this->renderable(function (ModelNotFoundException $exception, $request) {
            return JsonResponse::respondError(trans(JsonResponse::MSG_NOT_FOUND), ResponseStatus::NOT_FOUND);
        });
        $this->renderable(function (AccessDeniedHttpException $exception, $request) {
            return JsonResponse::respondError(trans(JsonResponse::MSG_NOT_AUTHORIZED), ResponseStatus::ACCESS_FORBIDDEN);
        });
        $this->renderable(function (BadRequestException $exception, $message) {
            return JsonResponse::respondError(trans('responses.' . $exception->getMessage()), ResponseStatus::ACCESS_FORBIDDEN);
        });

        $this->reportable(function (Throwable $exception) {
        });
    }
}
