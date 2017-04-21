<?php

namespace Sabichona\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return Response|JsonResponse
     */
    public function render($request, Exception $exception)
    {

        if ($exception instanceof NotFoundHttpException)
            return new JsonResponse([
                'status' => false,
                'message' => 'They say ignorance is bliss. I say is bullshit.',
            ], Response::HTTP_NOT_FOUND);

        if ($exception instanceof ValidationException)
            return $exception->getResponse();

        if ($exception instanceof ModelNotFoundException)
            return $this->resolveModelNotFound($exception->getModel());

        return new JsonResponse([
            'status' => false,
            'message' => 'I forgot how to serve a service.',
            'errors' => [
                $exception->getCode() => $exception->getMessage(),
            ],
        ], Response::HTTP_INTERNAL_SERVER_ERROR);

    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }

    /**
     * Resolve the not model found exception.
     *
     * @param $model
     * @return JsonResponse
     */
    protected function resolveModelNotFound($model)
    {

        $data = [
            'status' => false,
            'message' => 'What the hell are you talking about?',
        ];

        return new JsonResponse($data, Response::HTTP_NOT_FOUND);

    }
}
