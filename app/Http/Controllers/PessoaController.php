<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;

class PessoaController extends Controller
{
    // Listar todas as pessoas (GET)
    public function index()
    {
        return Pessoa::paginate(10);
    }

    // Criar uma nova pessoa (POST)
    public function store(Request $request)
    {
        $request->validate([
            'pes_nome' => 'required|string|max:100',
            'pes_data_nascimento' => 'required|date',
            'pes_sexo' => 'required|string|max:1',
            'pes_mae' => 'nullable|string|max:100',
            'pes_pai' => 'nullable|string|max:100',
        ]);

        return Pessoa::create($request->all());
    }

    // Mostrar uma pessoa específica (GET)
    public function show($id)
    {
        return Pessoa::findOrFail($id);
    }

    // Atualizar uma pessoa (PUT/PATCH)
    public function update(Request $request, $id)
    {
        $pessoa = Pessoa::findOrFail($id);

        $request->validate([
            'pes_nome' => 'sometimes|string|max:100',
            'pes_data_nascimento' => 'sometimes|date',
            'pes_sexo' => 'sometimes|string|max:1',
            'pes_mae' => 'nullable|string|max:100',
            'pes_pai' => 'nullable|string|max:100',
        ]);

        $pessoa->update($request->all());
        return $pessoa;
    }

    // Deletar uma pessoa (DELETE)
    public function destroy($id)
    {
        $pessoa = Pessoa::findOrFail($id);
        $pessoa->delete();
        return response()->json(['message' => 'Pessoa deletada com sucesso!'], 200);
    }
}
