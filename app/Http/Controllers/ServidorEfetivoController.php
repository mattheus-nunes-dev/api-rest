<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use App\Models\Lotacao;
use App\Models\Pessoa;
use App\Models\PessoaEndereco;
use App\Models\ServidorEfetivo;
use Illuminate\Http\Request;

class ServidorEfetivoController extends Controller
{
    // Listar todas as servidores efetivos (GET)
    public function index()
    {
        return ServidorEfetivo::paginate(10);
    }

    // Criar um novo servidor efetivo (POST)
    public function store(Request $request)
    {
        try {
            $request->validate([
                'pes_nome' => 'required|string|max:100',
                'pes_data_nascimento' => 'required|date',
                'pes_sexo' => 'required|string|max:1',
                'pes_mae' => 'nullable|string|max:100',
                'pes_pai' => 'nullable|string|max:100',
                'se_matricula' => 'required|string|max:20',
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
            $servidorEfetivo = ServidorEfetivo::insert([
                'pes_id' => $pessoa->pes_id,
                'se_matricula' => $request->se_matricula,
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

    // Mostrar um servidor efetivo (GET)
    public function show($id)
    {
        return ServidorEfetivo::where('pes_id', $id)->firstOrFail();
    }

    // Atualizar um servidor efetivo (PUT/PATCH)
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'pes_nome' => 'required|string|max:100',
                'pes_data_nascimento' => 'required|date',
                'pes_sexo' => 'required|string|max:1',
                'pes_mae' => 'nullable|string|max:100',
                'pes_pai' => 'nullable|string|max:100',
                'se_matricula' => 'required|string|max:20',
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
            $servidorEfetivo = ServidorEfetivo::where('pes_id', $id)->update([
                'se_matricula' => $request->se_matricula,
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

    // Deletar um servidor efetivo (DELETE)
    public function destroy($id)
    {
        $servidorEfetivo = ServidorEfetivo::where('pes_id', $id)->firstOrFail();
        $servidorEfetivo->delete();
        return response()->json(['message' => 'Servidor Efetivo deletada com sucesso!'], 200);
    }

    public function getServidorEfetivoLotUni($unidId)
    {
        try {
            $servidorEfetivos = ServidorEfetivo::select([
                                        'pessoa.pes_nome as nome',
                                        'pessoa.pes_data_nascimento as pes_data_nascimento',
                                        'unidade.unid_nome as unidade_lotacao'
                                ])
                                ->join('pessoa', 'pessoa.pes_id', '=', 'servidor_efetivo.pes_id')
                                ->join('lotacao', 'lotacao.pes_id', '=', 'servidor_efetivo.pes_id')
                                ->join('unidade', 'unidade.unid_id', '=', 'lotacao.unid_id')
                                ->where('lotacao.unid_id', $unidId)
                                ->get();
            if($servidorEfetivos->isEmpty()) {
                return response()->json(['error' => 'Nenhum servidor efetivo encontrado para esta unidade.'], 404);
            }else{
                $data = [];
                foreach ($servidorEfetivos as $servidor) {
                    $data[] = [
                        'Nome' => $servidor->nome,
                        'idade' => \Carbon\Carbon::parse($servidor->pes_data_nascimento)->age ?? '',
                        'unidade_lotacao' => $servidor->unidade_lotacao,
                        'fotografia' => '',
                    ];
                }
            }

            return response()->json([
                'error' => '',
                'data' => $data ?? ''
            ], 200);

        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage() ], 401);
        }
    }
}
