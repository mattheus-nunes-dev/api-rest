<?php

use App\Http\Controllers\CidadeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\ServidorEfetivoController;
use App\Http\Controllers\UnidadeController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['Credenciais incorretas.'],
        ]);
    }

    return $user->createToken('api-token')->plainTextToken;
});

// Route::apiResource('pessoas', PessoaController::class);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/pessoas', [PessoaController::class, 'index']);
    Route::get('/pessoas/{id}', [PessoaController::class, 'show']);
    Route::post('/pessoas', [PessoaController::class, 'store']);
    Route::put('/pessoas/{id}', [PessoaController::class, 'update']);
    Route::delete('/pessoas/{id}', [PessoaController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/unidades', [UnidadeController::class, 'index']);
    Route::get('/unidades/{id}', [UnidadeController::class, 'show']);
    Route::post('/unidades', [UnidadeController::class, 'store']);
    Route::put('/unidades/{id}', [UnidadeController::class, 'update']);
    Route::delete('/unidades/{id}', [UnidadeController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cidades', [CidadeController::class, 'index']);
    Route::get('/cidades/{id}', [CidadeController::class, 'show']);
    Route::post('/cidades', [CidadeController::class, 'store']);
    Route::put('/cidades/{id}', [CidadeController::class, 'update']);
    Route::delete('/cidades/{id}', [CidadeController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/servidor-efetivos', [ServidorEfetivoController::class, 'index']);
    Route::get('/servidor-efetivos/{id}', [ServidorEfetivoController::class, 'show']);
    Route::post('/servidor-efetivos', [ServidorEfetivoController::class, 'store']);
    Route::put('/servidor-efetivos/{id}', [ServidorEfetivoController::class, 'update']);
    Route::delete('/servidor-efetivos/{id}', [ServidorEfetivoController::class, 'destroy']);
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
