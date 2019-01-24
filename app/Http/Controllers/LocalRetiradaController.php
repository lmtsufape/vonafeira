<?php

namespace projetoGCA\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocalRetiradaController extends Controller
{
    public function listar($grupoconsumo_id){
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($grupoconsumo_id);
        $locaisRetirada = \projetoGCA\LocalRetirada::where('grupoconsumo_id','=',$grupoConsumo->id)->get();

        return view(
            'localretirada.listar', [
                'grupoConsumo' => $grupoConsumo,
                'locaisRetirada' => $locaisRetirada,
            ]
        );
    }

    public function adicionar($grupoconsumo_id){
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($grupoconsumo_id);
        
        return view(
            'localretirada.adicionar', [
                'grupoConsumo' => $grupoConsumo,
            ]
        );
    }

    public function criar (Request $request){
        $validator = Validator::make($request->all(), [
            'nome' => 'required|min:2|max:191',
        ]);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $local = new \projetoGCA\LocalRetirada();
        $local->grupoconsumo_id = $request->grupoConsumo;
        $local->nome = $request->nome;
        $local->save();

        return redirect()
                ->action('LocalRetiradaController@listar', $request->grupoConsumo);
    }

    public function editar ($grupoconsumo_id, $localretirada_id){
        $local = \projetoGCA\LocalRetirada::find($localretirada_id);
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($grupoconsumo_id);

        return view(
            'localretirada.editar',[
                'grupoConsumo' => $grupoConsumo,
                'local' => $local,
            ]
        );
    }

    public function atualizar (Request $request) {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|min:2|max:191',
        ]);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $local = \projetoGCA\LocalRetirada::find($request->id);
        $local->nome = $request->nome;
        $local->update();

        return redirect()
                ->action('LocalRetiradaController@listar', $request->grupoConsumo);        
    }

    public function remover ($grupoconsumo_id, $localretirada_id){
        $local = \projetoGCA\LocalRetirada::find($localretirada_id);

        $local->delete();

        return redirect()
                ->action('LocalRetiradaController@listar', $grupoconsumo_id);
    }
}
