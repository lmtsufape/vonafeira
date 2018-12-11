<?php

namespace projetoGCA\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnidadeVendaController extends Controller
{
    public function adicionar($grupoConsumoId){
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($grupoConsumoId);
        return view("unidadeVenda.adicionarUnidadeVenda", ['grupoConsumo' => $grupoConsumo]); 
    }

    public function cadastrar(Request $request){
        
        $validator = Validator::make($request->all(), [
            'nome' => 'required|unique:unidade_vendas|min:3|max:50',
            'descricao' => 'min:0',
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
        $unidadesVenda = \projetoGCA\UnidadeVenda::where("grupoConsumoId","=",$grupoConsumo->id)->get();
        return view(
            "unidadeVenda.unidadesVenda",
            ['listaUnidades' => $unidadesVenda,
            'grupoConsumo' => $grupoConsumo]
        );    	
    }

    public function editar($id) {
        $unidadeVenda = \projetoGCA\UnidadeVenda::find($id);   
        return view("unidadeVenda.editarUnidadeVenda", ['unidadeVenda' => $unidadeVenda]);
    } 

    public function atualizar(Request $request){
        $unidadeVenda = \projetoGCA\UnidadeVenda::find($request->id);

        if($request->nome == $unidadeVenda->nome){
            $validator = Validator::make($request->all(), [
                'descricao' => 'min:0',
                'is_fracionado' => 'required',
                'is_porcao' => 'required',
            ]);
    
            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
    
            $unidadeVenda->nome = $request->nome;
            $unidadeVenda->descricao = $request->descricao;
            $unidadeVenda->is_fracionado = $request->is_fracionado;
            $unidadeVenda->is_porcao = $request->is_porcao;
            $unidadeVenda->update();

        }else{
            $validator = Validator::make($request->all(), [
                'nome' => 'required|unique:unidade_vendas|min:3|max:50',
                'descricao' => 'min:0',
                'is_fracionado' => 'required',
                'is_porcao' => 'required',
            ]);
    
            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
    
            $unidadeVenda->nome = $request->nome;
            $unidadeVenda->descricao = $request->descricao;
            $unidadeVenda->is_fracionado = $request->is_fracionado;
            $unidadeVenda->is_porcao = $request->is_porcao;
            $unidadeVenda->update();
        }

        return redirect("/unidadesVenda/{$unidadeVenda->grupoConsumoId}");
    }

    public function verificarExistencia($nome){
        $unidadeVenda = \projetoGCA\UnidadeVenda::where ('nome', '=', $nome)->first();
        return empty($unidadeVenda);
    }

    public function remover($id) {
        $unidadeVenda = \projetoGCA\UnidadeVenda::find($id); 
        $unidadeVenda->delete();  
        return back()
                ->withInput();
    }
}
