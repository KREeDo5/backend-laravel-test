<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Api\Middleware\TransformApiResponse;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Единая обёртка API-ответов {"meta", "data"} — глобально на группу api
        // (практика api_architecture/Return API responses correctly.md)
        $middleware->appendToGroup('api', [
            TransformApiResponse::class,
        ]);

        // Гости API получают JSON 401 вместо редиректа на несуществующий route(login)
        $middleware->redirectGuestsTo(fn () => null);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // AuthenticationException → JSON 401 в единой обёртке
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'meta' => ['success' => false, 'message' => 'Требуется авторизация.'],
                    'data' => (object) [],
                ], 401);
            }
        });
    })->create();
