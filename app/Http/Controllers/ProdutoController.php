<?php

namespace projetoGCA\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ProdutoController extends Controller
{
    
    public function novo($idGrupoConsumo){
        $unidadeVenda = \projetoGCA\UnidadeVenda::all();
        $grupoConsumo = \projetoGCA\GrupoConsumo::where('id','=',$idGrupoConsumo)->first();
        return view("produto.adicionarProduto", ['unidadesVenda' => $unidadeVenda], ['grupoConsumo' => $grupoConsumo]); 
    }

    public function cadastrar(Request $request){
        $validator = Validator::make($request->all(), [
            'nomeProdutor' => 'required|min:4|max:191',
            'nome' => 'required|min:4|max:191',
            'descricao' => 'max:191',
            'preco' => 'required|numeric',
        ]);
        
        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }
        
        $produto = new \projetoGCA\Produto();
        $produto->nome_produtor = $request->nomeProdutor;
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

    public function editar($id) {
        $produto = \projetoGCA\Produto::find($id);
        $grupoConsumo = \projetoGCA\GrupoConsumo::where('id','=',$produto->grupoconsumo_id)->first();
        //dd($grupoConsumo);
        $unidadeVenda = \projetoGCA\UnidadeVenda::all();   
        return view(
            "produto.editarProduto",
            ['grupoConsumo' => $grupoConsumo,
            'unidadesVenda' => $unidadeVenda,
            'produto' => $produto]
        );
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
            $produto->nome_produtor = $request->nomeProdutor;
            $produto->nome = $request->nome;
            $produto->preco = $request->preco;
            $produto->descricao = $request->descricao;
            $produto->unidadevenda_id = $request->unidadeVenda;
            $produto->grupoconsumo_id = $request->grupoConsumo;
            $produto->update();

            return redirect()
                    ->action('ProdutoController@listar', $request->grupoConsumo)
                    ->withInput();
        }
        else if($this->verificarExistencia($request->nome) ){
            $produto->nome_produtor = $request->nomeProdutor;
            $produto->nome = $request->nome;
            $produto->preco = $request->preco;
            $produto->descricao = $request->descricao;
            $produto->unidadevenda_id = $request->unidadeVenda;
            $produto->grupoconsumo_id = $request->grupoConsumo;
            $produto->update();

            return redirect()
                    ->action('ProdutoController@listar', $request->grupoConsumo)
                    ->withInput();
        }
        return redirect("/erroCadastroExiste");
    }

    public function listar($idGrupoConsumo){
        if(Auth::check()){
            $grupoConsumo = \projetoGCA\GrupoConsumo::where('id','=',$idGrupoConsumo)->first();

            $produtos = \projetoGCA\Produto::where('grupoconsumo_id', '=', $idGrupoConsumo)->get();        
            return view("produto.produtos", ['produtos' => $produtos], ['grupoConsumo' => $grupoConsumo]);  
        }
        return view("/home");
    }

    public function verificarExistencia($nome){
        $produto = \projetoGCA\Produto::where ('nome', '=', $nome)->first();
        return empty($produto);
    }
}
