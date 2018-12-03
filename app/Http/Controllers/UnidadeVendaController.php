<?php

namespace projetoGCA\Http\Controllers;

use Illuminate\Http\Request;

class UnidadeVendaController extends Controller
{
    public function adicionar(){
        // chama view de adição de unidade de venda
        return view("unidadeVenda.adicionarUnidadeVenda"); 
    }

    public function cadastrar(Request $request){
        
        if($this->verificarExistencia($request->nome)){
            $unidadeVenda = new \projetoGCA\UnidadeVenda();
            $unidadeVenda->nome = $request->nome;
            $unidadeVenda->descricao = $request->descricao;
            $unidadeVenda->is_fracionado = $request->is_fracionado;
            $unidadeVenda->is_porcao = $request->is_porcao;
            $unidadeVenda->save();
            return redirect("/unidadesVenda");
        }

        return redirect("/erroCadastroExiste");
                
    }

    public function listar () {
        $unidadesVenda = \projetoGCA\UnidadeVenda::all();
        return view("unidadeVenda.unidadesVenda", ['listaUnidades' => $unidadesVenda]);    	
    }

    public function editar($id) {
        $unidadeVenda = \projetoGCA\UnidadeVenda::find($id);   
        return view("unidadeVenda.editarUnidadeVenda", ['unidadeVenda' => $unidadeVenda]);
    } 

    public function atualizar(Request $request){
        $unidadeVenda = \projetoGCA\UnidadeVenda::find($request->id);
        if($unidadeVenda->nome == $request->nome){
            $unidadeVenda->nome = $request->nome;
            $unidadeVenda->descricao = $request->descricao;
            $unidadeVenda->is_fracionado = $request->is_fracionado;
            $unidadeVenda->is_porcao = $request->is_porcao;
            $unidadeVenda->update();

            return redirect("/unidadesVenda");
        }
        else if($this->verificarExistencia($request->nome) ){
            $unidadeVenda->nome = $request->nome;
            $unidadeVenda->descricao = $request->descricao;
            $unidadeVenda->is_fracionado = $request->is_fracionado;
            $unidadeVenda->is_porcao = $request->is_porcao;
            $unidadeVenda->update();

            return redirect("/unidadesVenda");
        }
        return redirect("/erroCadastroExiste");
    }

    public function verificarExistencia($nome){
        $unidadeVenda = \projetoGCA\UnidadeVenda::where ('nome', '=', $nome)->first();
        return empty($unidadeVenda);
    }

    public function remover($id) {
        $unidadeVenda = \projetoGCA\UnidadeVenda::find($id); 
        $unidadeVenda->delete();  
        return redirect()
                ->action('UnidadeVendaController@listar')
                ->withInput();
    }
}
