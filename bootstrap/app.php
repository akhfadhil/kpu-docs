<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . "/../routes/web.php",
        commands: __DIR__ . "/../routes/console.php",
        health: "/up",
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            // 'auth.custom' => \App\Http\Middleware\AuthMiddleware::class,
            "check.login" => \App\Http\Middleware\AuthMiddleware::class,
            "check.role" => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (
            \Symfony\Component\HttpKernel\Exception\HttpException $e,
            $request,
        ) {
            if ($e->getStatusCode() === 403) {
                return redirect()
                    ->back()
                    ->with(
                        "error",
                        "Anda tidak memiliki izin untuk mengakses halaman ini.",
                    )
                    ->with("toast", true);
            }

            if ($e->getStatusCode() === 404) {
                return response()->view("errors.404", [], 404);
            }
        });
        // Tangani error umum (500, runtime error, dll)
        // $exceptions->render(function (Throwable $e, $request) {
        //     return response()->view("errors.500", [], 500);
        // });
    })
    ->create();
