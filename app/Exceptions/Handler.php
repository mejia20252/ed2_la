<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * Una lista de las excepciones que no se reportarán.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        // Aquí se pueden agregar excepciones que no desees reportar
    ];

    /**
     * Registra las excepciones en el log.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception): void
    {
        parent::report($exception);
    }

    /**
     * Renderiza una respuesta para una excepción.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {
        // FORZAR siempre respuesta JSON (esto elimina HTML en todos los casos)
        
        // Manejar errores de validación (422)
        if ($exception instanceof ValidationException) {
            return response()->json([
                'error' => 'Error de validación',
                'message' => $exception->getMessage(),
                'errors' => $exception->errors()
            ], 422);
        }

        // Manejar errores 404
        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'error' => 'Recurso no encontrado',
                'message' => 'La ruta solicitada no existe'
            ], 404);
        }

        // Manejar errores de autenticación (401)
        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'error' => 'No autenticado',
                'message' => $exception->getMessage()
            ], 401);
        }

        // Manejar cualquier HttpException (400, 403, 500, etc.)
        if ($exception instanceof HttpException) {
            return response()->json([
                'error' => $exception->getMessage() ?: 'Error en el servidor',
                'status' => $exception->getStatusCode()
            ], $exception->getStatusCode());
        }

        // Para cualquier otra excepción, devolver 500
        return response()->json([
            'error' => 'Error interno del servidor',
            'message' => config('app.debug') ? $exception->getMessage() : 'Algo salió mal'
        ], 500);
    }
}