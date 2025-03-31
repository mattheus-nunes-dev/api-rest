<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use App\Models\Unidade;
use App\Models\UnidadeEndereco;
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
        try {
            $request->validate([
                'unid_nome' => 'required|string|max:200',
                'unid_sigla' => 'required|string|max:20',
                'end_tipo_logradouro' => 'required|string|max:50',
                'end_logradouro' => 'required|string|max:100',
                'end_numero' => 'required|string|max:10',
                'end_bairro' => 'required|string|max:50',
                'cid_id' => 'required|integer|exists:cidade,cid_id',
            ]);

            $unidade = Unidade::create([
                'unid_nome' => $request->unid_nome,
                'unid_sigla' => $request->unid_sigla,
            ]);

            $endereco = Endereco::create([
                'end_tipo_logradouro' => $request->end_tipo_logradouro,
                'end_logradouro' => $request->end_logradouro,
                'end_numero' => $request->end_numero,
                'end_bairro' => $request->end_bairro,
                'cid_id' => $request->cid_id,
            ]);

            UnidadeEndereco::insert([
                'unid_id' => $unidade->unid_id,
                'end_id' => $endereco->end_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'error' => '',
                'data' => $unidade ?? ''
            ], 200);

        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage() ], 401);
        }
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
            'end_tipo_logradouro' => 'required|string|max:50',
            'end_logradouro' => 'required|string|max:100',
            'end_numero' => 'required|string|max:10',
            'end_bairro' => 'required|string|max:50',
            'cid_id' => 'required|integer|exists:cidade,cid_id',
        ]);

        $unidade->update([
            'unid_nome' => $request->unid_nome,
            'unid_sigla' => $request->unid_sigla,
        ]);
        $unidadeEndereco = UnidadeEndereco::where('unid_id', $unidade->unid_id)->first();
        $endereco = Endereco::where('end_id', $unidadeEndereco->end_id)->first();
        $endereco->update([
            'end_tipo_logradouro' => $request->end_tipo_logradouro,
            'end_logradouro' => $request->end_logradouro,
            'end_numero' => $request->end_numero,
            'end_bairro' => $request->end_bairro,
            'cid_id' => $request->cid_id,
        ]);

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
