<?php

use App\Http\Controllers\CidadeController;
use App\Http\Controllers\FileUploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\ServidorEfetivoController;
use App\Http\Controllers\ServidorTemporarioController;
use App\Http\Controllers\UnidadeController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

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

Route::post('/renovar-token', function (Request $request) {
    $request->validate([
        'token' => 'required|string',
    ]);
    $token = PersonalAccessToken::findToken($request->token);

    if (!$token || !$token->tokenable) {
        return response()->json(['error' => 'Token inválido'], 401);
    }

    $token->update([
        'expires_at' => now()->addMinutes(5)
    ]);

    return response()->json([
        'mensagem' => 'Token renovado com sucesso',
        'token' => $request->token,
        'expira_em' => $token->expires_at
    ]);
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
    Route::get('/servidor-efetivos-unidade/{id}', [ServidorEfetivoController::class, 'getServidorEfetivoLotUni']);
    Route::get('/servidor-efetivos-endereco/{nome}', [ServidorEfetivoController::class, 'getServidorEfetivoPorNome']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/servidor-temporarios', [ServidorTemporarioController::class, 'index']);
    Route::get('/servidor-temporarios/{id}', [ServidorTemporarioController::class, 'show']);
    Route::post('/servidor-temporarios', [ServidorTemporarioController::class, 'store']);
    Route::put('/servidor-temporarios/{id}', [ServidorTemporarioController::class, 'update']);
    Route::delete('/servidor-temporarios/{id}', [ServidorTemporarioController::class, 'destroy']);
});

Route::post('/upload', [FileUploadController::class, 'upload'])->middleware('auth:sanctum');
Route::post('/upload-fotos', [FileUploadController::class, 'uploadFotos'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
