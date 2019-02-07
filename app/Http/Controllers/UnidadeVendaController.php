<?php

namespace projetoGCA\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UnidadeVendaController extends Controller
{
    public function adicionar($grupoConsumoId){
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($grupoConsumoId);
        return view("unidadeVenda.adicionarUnidadeVenda", ['grupoConsumo' => $grupoConsumo]);
    }

    public function cadastrar(Request $request){

        $validator = Validator::make($request->all(), [
            'nome' => ['required','min:2','max:50',Rule::unique('unidade_vendas','nome')
                          ->where(function($query) use ($request){ $query->where('grupoConsumoId', $request->grupoConsumoId)
                                                                         ->whereNull('deleted_at'); })
                      ],
            'descricao' => 'max:191',
            'is_fracionado' => 'required',
            'is_porcao' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $unidadeVenda = new \projetoGCA\UnidadeVenda();
        $unidadeVenda->grupoConsumoId = $request->grupoConsumoId;
        $unidadeVenda->nome = $request->nome;
        $unidadeVenda->descricao = $request->descricao;
        $unidadeVenda->is_fracionado = $request->is_fracionado;
        $unidadeVenda->is_porcao = $request->is_porcao;
        $unidadeVenda->save();

        return redirect("/unidadesVenda/{$unidadeVenda->grupoConsumoId}");

    }

    public function listar ($grupoConsumoId) {
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($grupoConsumoId);
        $unidadesVenda = \projetoGCA\UnidadeVenda::where("grupoConsumoId","=",$grupoConsumo->id)->orderBy('nome')->get();
        return view(
            "unidadeVenda.unidadesVenda",
            ['listaUnidades' => $unidadesVenda,
            'grupoConsumo' => $grupoConsumo]
        );
    }

    public function editar($grupoConsumoId, $id) {
        $unidadeVenda = \projetoGCA\UnidadeVenda::find($id);
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($grupoConsumoId);
        return view("unidadeVenda.editarUnidadeVenda", ['unidadeVenda' => $unidadeVenda, 'grupoConsumo' => $grupoConsumo]);
    }

    public function atualizar(Request $request){
        $unidadeVenda = \projetoGCA\UnidadeVenda::find($request->id);

        if($request->nome == $unidadeVenda->nome){
            $validator = Validator::make($request->all(), [
                'nome' => 'required|min:2|max:50',
                'descricao' => 'max:191',
                'is_fracionado' => 'required',
                'is_porcao' => 'required',
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

        }else{
            $validator = Validator::make($request->all(), [
              'nome' => ['required','min:2','max:50',Rule::unique('unidade_vendas','nome')
                            ->where(function($query) use ($request){ $query->where('grupoConsumoId', $request->grupoConsumoId)
                                                                           ->whereNull('deleted_at'); })
                        ],
                'descricao' => 'max:191',
                'is_fracionado' => 'required',
                'is_porcao' => 'required',
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

        }

        $unidadeVenda->nome = $request->nome;
        $unidadeVenda->descricao = $request->descricao;
        $unidadeVenda->is_fracionado = $request->is_fracionado;
        $unidadeVenda->is_porcao = $request->is_porcao;
        $unidadeVenda->update();

        return redirect("/unidadesVenda/{$unidadeVenda->grupoConsumoId}");
    }

    public function remover($id) {
        $unidadeVenda = \projetoGCA\UnidadeVenda::find($id);

        $produtos = \projetoGCA\Produto::where('unidadevenda_id','=',$unidadeVenda->id)->get();

        foreach ($produtos as $produto) {
          $produto->delete();
        }

        $unidadeVenda->delete();

        return back()
                ->withInput();
    }
}
