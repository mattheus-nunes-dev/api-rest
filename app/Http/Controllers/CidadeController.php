<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use Illuminate\Http\Request;

class CidadeController extends Controller
{
    // Listar todas as Cidades (GET)
    public function index()
    {
        return Cidade::paginate(10);
    }

    // Criar uma nova Cidade (POST)
    public function store(Request $request)
    {
        $request->validate([
            'cid_nome' => 'required|string|max:200',
            'cid_uf' => 'required|string|max:2',
        ]);

        return Cidade::create($request->all());
    }

    // Mostrar uma Cidade específica (GET)
    public function show($id)
    {
        return Cidade::findOrFail($id);
    }

    // Atualizar uma Cidade (PUT/PATCH)
    public function update(Request $request, $id)
    {
        $cidade = Cidade::findOrFail($id);

        $request->validate([
            'cid_nome' => 'required|string|max:200',
            'cid_uf' => 'required|string|max:2',
        ]);

        $cidade->update($request->all());
        return $cidade;
    }

    // Deletar uma Cidade (DELETE)
    public function destroy($id)
    {
        $cidade = Cidade::findOrFail($id);
        $cidade->delete();
        return response()->json(['message' => 'Cidade deletada com sucesso!'], 200);
    }
}
