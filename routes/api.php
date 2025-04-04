<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TravelRequestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Aqui estão definidas as rotas da API protegidas por JWT
*/

// Rotas públicas (sem autenticação)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rotas protegidas (JWT necessário)
Route::middleware('auth:api')->group(function () {
    // Criar novo pedido
    Route::post('/travel-requests', [TravelRequestController::class, 'store']);

    // Listar pedidos com filtros
    Route::get('/travel-requests', [TravelRequestController::class, 'index']);

    // Ver pedido por ID
    Route::get('/travel-requests/{id}', [TravelRequestController::class, 'show']);

    // Atualizar status (somente o dono)
    Route::patch('/travel-requests/{id}/status', [TravelRequestController::class, 'updateStatus']);

    // Cancelar pedido (se aprovado e for dono)
    Route::delete('/travel-requests/{id}', [TravelRequestController::class, 'cancel']);
});
