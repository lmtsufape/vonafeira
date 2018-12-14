<?php

namespace projetoGCA\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use \projetoGCA\Contato;
class ContatoController extends Controller
{
    public function novo(){
        return view('contato.novo');
    }

    public function cadastrar(Request $request){
        
        $contato = new Contato();
        $user_id = Auth::user()->id;
        $contato->telefone = $request->telefone;
        $contato->user_id = $user_id;
        $contato->save();
        return redirect()->action('ConsumidorController@selecionarGrupo');
    }
}
