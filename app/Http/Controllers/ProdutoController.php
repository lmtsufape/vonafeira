<?php

namespace projetoGCA\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ProdutoController extends Controller
{

    public function novo($idGrupoConsumo){
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($idGrupoConsumo);
        $unidadeVenda = \projetoGCA\UnidadeVenda::where('grupoConsumoId','=',$idGrupoConsumo)->get();
        $produtores = \projetoGCA\Produtor::where('grupoconsumo_id','=',$idGrupoConsumo)->get();

        return view("produto.adicionarProduto", ['unidadesVenda' => $unidadeVenda,
                                                'grupoConsumo' => $grupoConsumo,
                                                'produtores' => $produtores]
                                              );
    }

    public function cadastrar(Request $request){
        $validator = Validator::make($request->all(), [
            // 'nome' => 'required|unique:produtos,nome,NULL,id,deleted_at,NULL|min:2|max:191',
            'nome' => ['required','min:2','max:191',Rule::unique('produtos','nome')
                          ->where(function($query) use ($request){ $query->where('grupoconsumo_id', $request->grupoConsumo)
                                                                         ->whereNull('deleted_at'); })
                      ],
            'descricao' => 'max:191',
            'preco' => 'required|numeric',
            'unidadeVenda' => 'required',
            'idProdutor' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $produto = new \projetoGCA\Produto();
        $produto->produtor_id = $request->idProdutor;
        $produto->nome = $request->nome;
        $produto->preco = $request->preco;
        $produto->descricao = $request->descricao;
        $produto->unidadevenda_id = $request->unidadeVenda;
        $produto->grupoconsumo_id = $request->grupoConsumo;
        $produto->save();
        return redirect()
                ->action('ProdutoController@listar', $request->grupoConsumo)
                ->withInput();

    }

    public function editar($produto_id) {
        $produto = \projetoGCA\Produto::find($produto_id);
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($produto->grupoconsumo->id);
        $unidadeVenda = \projetoGCA\UnidadeVenda::where('grupoConsumoId','=',$grupoConsumo->id)->get();
        $produtores = \projetoGCA\Produtor::where('grupoconsumo_id','=',$grupoConsumo->id)->get();

        return view(
            "produto.editarProduto", ['grupoConsumo' => $grupoConsumo,
                                      'unidadesVenda' => $unidadeVenda,
                                      'produto' => $produto,
                                      'produtores' => $produtores]);
    }

    public function remover($id) {
        $produto = \projetoGCA\Produto::find($id);
        // return var_dump($produto);
        $grupoConsumo = $produto->grupoconsumo_id;
        // return var_dump($produto);
        $produto->delete();
        return redirect()
                ->action('ProdutoController@listar', $grupoConsumo)
                ->withInput();
    }

    public function atualizar(Request $request){
        $produto = \projetoGCA\Produto::find($request->id);

        if($produto->nome == $request->nome){
            $validator = Validator::make($request->all(), [
                'nome' => 'required|min:2|max:191',
                'descricao' => 'max:191',
                'preco' => 'required|numeric',
                'unidadeVenda' => 'required',
                'idProdutor' => 'required'
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
        }
        else{
            $validator = Validator::make($request->all(), [
                'nome' => ['required','min:2','max:191',Rule::unique('produtos','nome')
                            ->where(function($query) use ($request){ $query->where('grupoconsumo_id', $request->grupoConsumo)
                                                                           ->whereNull('deleted_at'); })
                        ],
                'descricao' => 'max:191',
                'preco' => 'required|numeric',
                'unidadeVenda' => 'required',
                'idProdutor' => 'required'
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
        }

        $produto->produtor_id = $request->idProdutor;
        $produto->nome = $request->nome;
        $produto->preco = $request->preco;
        $produto->descricao = $request->descricao;
        $produto->unidadevenda_id = $request->unidadeVenda;
        $produto->grupoconsumo_id = $request->grupoConsumoId;
        $produto->update();

        return redirect()
                    ->action('ProdutoController@listar', $request->grupoConsumoId)
                    ->withInput();
    }

    public function listar($idGrupoConsumo){
        if(Auth::check()){
            $grupoConsumo = \projetoGCA\GrupoConsumo::where('id','=',$idGrupoConsumo)->first();

            $produtos = \projetoGCA\Produto::where('grupoconsumo_id', '=', $idGrupoConsumo)->orderBy('nome')->get();
            return view("produto.produtos", ['produtos' => $produtos], ['grupoConsumo' => $grupoConsumo]);
        }
        return view("/home");
    }
}
