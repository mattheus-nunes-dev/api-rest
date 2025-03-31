<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    // Listar todas as unidades (GET)
    public function index()
    {
        return Unidade::paginate(10);
    }

    // Criar uma nova unidade (POST)
    public function store(Request $request)
    {
        $request->validate([
            'unid_nome' => 'required|string|max:200',
            'unid_sigla' => 'required|string|max:20',
        ]);

        return Unidade::create($request->all());
    }

    // Mostrar uma Unidade específica (GET)
    public function show($id)
    {
        return Unidade::findOrFail($id);
    }

    // Atualizar uma Unidade (PUT/PATCH)
    public function update(Request $request, $id)
    {
        $unidade = Unidade::findOrFail($id);

        $request->validate([
            'unid_nome' => 'required|string|max:200',
            'unid_sigla' => 'required|string|max:20',
        ]);

        $unidade->update($request->all());
        return $unidade;
    }

    // Deletar uma Unidade (DELETE)
    public function destroy($id)
    {
        $unidade = Unidade::findOrFail($id);
        $unidade->delete();
        return response()->json(['message' => 'Unidade deletada com sucesso!'], 200);
    }
}
