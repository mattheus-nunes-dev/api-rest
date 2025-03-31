<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use App\Models\Lotacao;
use App\Models\Pessoa;
use App\Models\PessoaEndereco;
use App\Models\ServidorTemporario;
use Illuminate\Http\Request;

class ServidorTemporarioController extends Controller
{
    // Listar todas as servidores Temporarios (GET)
    public function index()
    {
        return ServidorTemporario::paginate(10);
    }

    // Criar um novo servidor Temporario (POST)
    public function store(Request $request)
    {
        try {
            $request->validate([
                'pes_nome' => 'required|string|max:100',
                'pes_data_nascimento' => 'required|date',
                'pes_sexo' => 'required|string|max:1',
                'pes_mae' => 'nullable|string|max:100',
                'pes_pai' => 'nullable|string|max:100',
                'sf_data_admissao' => 'required|date',
                'sf_data_demissao' => 'nullable|date',
                'end_tipo_logradouro' => 'required|string|max:50',
                'end_logradouro' => 'required|string|max:100',
                'end_numero' => 'required|string|max:10',
                'end_bairro' => 'required|string|max:50',
                'cid_id' => 'required|integer|exists:cidade,cid_id',
                'unid_id' => 'required|integer|exists:unidade,unid_id',
                'lot_data_lotacao' => 'required|date',
                'lot_data_remocao' => 'nullable|date',
                'lot_portaria' => 'required|string|max:100',
            ]);

            $pessoa = Pessoa::create([
                'pes_nome' => $request->pes_nome,
                'pes_data_nascimento' => $request->pes_data_nascimento,
                'pes_sexo' => $request->pes_sexo,
                'pes_mae' => $request->pes_mae,
                'pes_pai' => $request->pes_pai,
            ]);
            $servidorTemporario = ServidorTemporario::insert([
                'pes_id' => $pessoa->pes_id,
                'sf_data_admissao' => $request->sf_data_admissao,
                'sf_data_demissao' => $request->sf_data_demissao,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $lotacao = Lotacao::create([
                'pes_id' => $pessoa->pes_id,
                'unid_id' => $request->unid_id,
                'lot_data_lotacao' => $request->lot_data_lotacao,
                'lot_data_remocao' => $request->lot_data_remocao,
                'lot_portaria' => $request->lot_portaria,
            ]);

            $endereco = Endereco::create([
                'end_tipo_logradouro' => $request->end_tipo_logradouro,
                'end_logradouro' => $request->end_logradouro,
                'end_numero' => $request->end_numero,
                'end_bairro' => $request->end_bairro,
                'cid_id' => $request->cid_id,
            ]);

            PessoaEndereco::insert([
                'pes_id' => $pessoa->pes_id,
                'end_id' => $endereco->end_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'error' => '',
                'data' => $pessoa ?? ''
            ], 200);

        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage() ], 401);
        }

        return $pessoa;
    }

    // Mostrar um servidor Temporario (GET)
    public function show($id)
    {
        return ServidorTemporario::where('pes_id', $id)->firstOrFail();
    }

    // Atualizar um servidor Temporario (PUT/PATCH)
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'pes_nome' => 'required|string|max:100',
                'pes_data_nascimento' => 'required|date',
                'pes_sexo' => 'required|string|max:1',
                'pes_mae' => 'nullable|string|max:100',
                'pes_pai' => 'nullable|string|max:100',
                'sf_data_admissao' => 'required|date',
                'sf_data_demissao' => 'nullable|date',
                'end_tipo_logradouro' => 'required|string|max:50',
                'end_logradouro' => 'required|string|max:100',
                'end_numero' => 'required|string|max:10',
                'end_bairro' => 'required|string|max:50',
                'cid_id' => 'required|integer|exists:cidade,cid_id',
                'unid_id' => 'required|integer|exists:unidade,unid_id',
                'lot_data_lotacao' => 'required|date',
                'lot_data_remocao' => 'nullable|date',
                'lot_portaria' => 'required|string|max:100',
            ]);
            $pessoa = Pessoa::findOrFail($id);
            $pessoa->update([
                'pes_nome' => $request->pes_nome,
                'pes_data_nascimento' => $request->pes_data_nascimento,
                'pes_sexo' => $request->pes_sexo,
                'pes_mae' => $request->pes_mae,
                'pes_pai' => $request->pes_pai,
            ]);
            $servidorTemporario = ServidorTemporario::where('pes_id', $id)->update([
                'sf_data_admissao' => $request->sf_data_admissao,
                'sf_data_demissao' => $request->sf_data_demissao,
                'updated_at' => now()
            ]);

            $lotacao = Lotacao::where('pes_id', $id)->firstOrFail();
            $lotacao->update([
                'unid_id' => $request->unid_id,
                'lot_data_lotacao' => $request->lot_data_lotacao,
                'lot_data_remocao' => $request->lot_data_remocao,
                'lot_portaria' => $request->lot_portaria,
            ]);

            $pessoaEndereco = PessoaEndereco::where('pes_id', $id)->firstOrFail();
            $endereco = Endereco::where('end_id', $pessoaEndereco->end_id)->firstOrFail();
            $endereco->update([
                'end_tipo_logradouro' => $request->end_tipo_logradouro,
                'end_logradouro' => $request->end_logradouro,
                'end_numero' => $request->end_numero,
                'end_bairro' => $request->end_bairro,
                'cid_id' => $request->cid_id,
            ]);

            return response()->json([
                'error' => '',
                'data' => $pessoa ?? ''
            ], 200);

        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage() ], 401);
        }
    }

    // Deletar um servidor Temporario (DELETE)
    public function destroy($id)
    {
        $servidorTemporario = ServidorTemporario::where('pes_id', $id)->firstOrFail();
        $servidorTemporario->delete();
        return response()->json(['message' => 'Servidor Temporario deletada com sucesso!'], 200);
    }
}
