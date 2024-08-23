<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (QueryException $e, $request) {
            // Verifica se o erro é relacionado a "Column not found"
            if ($e->getCode() == '42S22') {
                // Loga o erro para análise futura
                Log::error('Column not found: ' . $e->getMessage());

                // Retorna uma resposta amigável
                return response()->json([
                    'error' => 'A coluna especificada não foi encontrada no banco de dados. Por favor, verifique sua consulta.',
                ], 500);
            }
        });
    }
}
