<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoaController;
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
Route::get('/pessoas', [PessoaController::class, 'index']);
Route::get('/pessoas/{id}', [PessoaController::class, 'show']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/pessoas', [PessoaController::class, 'store']);
    Route::put('/pessoas/{id}', [PessoaController::class, 'update']);
    Route::delete('/pessoas/{id}', [PessoaController::class, 'destroy']);
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
