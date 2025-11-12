<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Forzar TODAS las respuestas a JSON
        $exceptions->shouldRenderJsonWhen(fn () => true);

        // Manejar 404
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->json([
                'error' => 'Recurso no encontrado',
                'message' => 'La ruta solicitada no existe'
            ], 404);
        });

        // Manejar errores de validación
        $exceptions->render(function (ValidationException $e, Request $request) {
            return response()->json([
                'error' => 'Error de validación',
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        });

        // Manejar HttpException (400, 403, 500, etc.)
        $exceptions->render(function (HttpException $e, Request $request) {
            return response()->json([
                'error' => $e->getMessage() ?: 'Error en el servidor',
                'status' => $e->getStatusCode()
            ], $e->getStatusCode());
        });

        // Manejar cualquier otra excepción
        $exceptions->render(function (Throwable $e, Request $request) {
            // Verificar si es HttpException para obtener el código de estado
            if ($e instanceof HttpException) {
                $statusCode = $e->getStatusCode();
            } else {
                $statusCode = 500;
            }
            
            return response()->json([
                'error' => 'Error interno del servidor',
                'message' => config('app.debug') ? $e->getMessage() : 'Algo salió mal',
                'file' => config('app.debug') ? $e->getFile() : null,
                'line' => config('app.debug') ? $e->getLine() : null,
            ], $statusCode);
        });
    })
    ->create();