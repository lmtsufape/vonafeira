<?php

namespace projetoGCA\Http\Controllers;

use Illuminate\Http\Request;

class TipoUsuarioController extends Controller
{
    public function adicionar(Request $request){
        $tipoUsuario = new \projetoGCA\TipoUsuario();
        $tipoUsuario->nome = $request->nome;
        $tipoUsuario->descricao = $request->descricao;
        $tipoUsuario->isprodutor = $request->isprodutor;
        $tipoUsuario->iscoordenador = $request->iscoordenador;
        $tipoUsuario->isconsumidor = $request->isconsumidor;
        $tipoUsuario->save();
    }
}
