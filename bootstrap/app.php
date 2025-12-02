<?php

use App\Exceptions\CustomException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ErrorException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->apiResponse($e);
            }
        });
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->apiResponse($e);
            }
        });
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                $errors = $e->errors();
                return response()->json([
                    'status' => false,
                    'message' => 'Validation errors',
                    'errors' => $errors
                ], 422);
            }
        });
        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
               
                return response()->json([
                    'status' => false,
                    'message' => 'Access denied',
                    'errors' => []
                ], 403);
            }
        });
        
        
       
    })->create();
