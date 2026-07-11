<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'donasi/webhook',
            'donasi/mock-payment-status',
        ]);

        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\SecurityHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (QueryException $e, Request $request) {
            if (!config('app.debug')) {
                Log::error('Database Query Exception: ' . $e->getMessage(), [
                    'sql' => $e->getSql(),
                    'bindings' => $e->getBindings(),
                    'exception' => $e
                ]);

                if ($request->is('api/*') || $request->expectsJson()) {
                    return response()->json([
                        'message' => 'Internal Server Error: A database operation failed.'
                    ], 500);
                }

                abort(500, 'A database error occurred.');
            }
        });

        $exceptions->render(function (PDOException $e, Request $request) {
            if (!config('app.debug')) {
                Log::error('PDO Exception: ' . $e->getMessage(), [
                    'exception' => $e
                ]);

                if ($request->is('api/*') || $request->expectsJson()) {
                    return response()->json([
                        'message' => 'Internal Server Error: A database connection error occurred.'
                    ], 500);
                }

                abort(500, 'A database connection error occurred.');
            }
        });
    })->create();
