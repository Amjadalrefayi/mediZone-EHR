<?php

namespace App\Exceptions;

use App;
use App\Traits\ApiResponse;
use App\Traits\Helper;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse, Helper;

    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
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
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            if (app()->bound('sentry') && $this->shouldReport($e)) {
                app('sentry')->captureException($e);
            }
        });
    }

    /**
     * @throws Throwable
     */
    public function renderWeb($request, Throwable $e): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application|Response
    {
        if ($e instanceof AuthenticationException)
            return redirect(route('login'));

        return parent::render($request, $e);
    }

    public function render($request, Throwable $e): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|Response
    {
        //        $this->logRequest($request, $e);

        if (!$request->expectsJson())
            return $this->renderWeb($request, $e);

        if ($e instanceof AuthenticationException)
            return $this->responseMessage(__('Unauthorized'), Response::HTTP_UNAUTHORIZED);

        if ($e instanceof AuthorizationException)
            return $this->responseMessage(__($e->getMessage()), Response::HTTP_FORBIDDEN);

        if ($e instanceof ValidationException)
            return $this->response(
                __('The given data was invalid.'),
                $e->validator->messages()->messages(),
                null,
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        if ($e instanceof HttpException)
            return $this->responseMessage($e->getMessage(), $e->getStatusCode());

        if (App::environment('production')) {
            return $this->responseMessage(
                __('Something went wrong.'),
                $e->getCode()
            );
        }

        return parent::render($request, $e);
    }

    public function logRequest($request, Throwable $e): void
    {
        $exceptionType = get_class($e);
        $method = strtoupper($request->getMethod());

        $uri = $request->getPathInfo();

        $bodyAsJson = json_encode($request->except([
            'password',
            'password_confirmation',
        ]));

        $message = "from {$request->ip()},\n$method $uri - {$bodyAsJson}, $exceptionType";

        Log::critical($message);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->responseMessage('Unauthenticated', 401);
    }
}
