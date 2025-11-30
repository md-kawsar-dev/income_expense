<?php

namespace App\Exceptions;

use BadMethodCallException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register()
    {
        //
    }

    /**
     * Convert an authentication exception into a JSON response for API requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // যদি request API বা JSON চায় → JSON রেসপন্স
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated. Please login.',
                'errors' => [
                    'token' => ['Authentication token missing or invalid.']
                ]
            ], 401);
        }

        // অন্যথায় default behaviour (redirect)
        return redirect()->guest('/login');
    }

    /**
     * Render exceptions into HTTP responses.
     */
    public function render($request, Throwable $exception)
    {
        if (($request->expectsJson() || $request->is('api/*')) &&$exception instanceof BadMethodCallException) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid method call. The requested function does not exist.',
                'error' => $exception->getMessage(),
            ], 500);
        }
        // 404 route not found
        if (($request->expectsJson() || $request->is('api/*')) && $exception instanceof NotFoundHttpException) {
            return response()->json([
                'status' => false,
                'message' => 'Route not found.'
            ], 404);
        }
        // Validation exception → 422 (consistent JSON)
        if (($request->expectsJson() || $request->is('api/*')) && $exception instanceof ValidationException) {
            $errors = $exception->errors();
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $errors
            ], 422);
        }

        // Authorization (403)
        if (($request->expectsJson() || $request->is('api/*')) && $exception instanceof AuthorizationException) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to access this resource.'
            ], 403);
        }

        // Model not found → 404
        if (($request->expectsJson() || $request->is('api/*')) && $exception instanceof ModelNotFoundException) {
            $model = class_basename($exception->getModel());
            return response()->json([
                'status' => false,
                'message' => "{$model} not found."
            ], 404);
        }

        // HTTP exceptions (like 404 route not found, method not allowed, etc.)
        if (($request->expectsJson() || $request->is('api/*')) && $exception instanceof HttpException) {
            $status = $exception->getStatusCode();
            $message = $exception->getMessage() ?: ($status === 404 ? 'Not Found' : 'HTTP error');
            return response()->json([
                'status' => false,
                'message' => $message
            ], $status);
        }

        // For API requests prefer a JSON 500 for unexpected errors
        if ($request->expectsJson() || $request->is('api/*')) {
            // In production you might want to hide $exception->getMessage()
            return response()->json([
                'status' => false,
                'message' => 'Server Error',
                'error' => config('app.debug') ? $exception->getMessage() : null
            ], 500);
        }

        return parent::render($request, $exception);
    }
}
