<?php

namespace projetoGCA\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function adicionar(Request $request){
        if ($this->verificarExistencia($request->email)){
            $user = new \projetoGCA\User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save();
            return redirect("/listarUsuarios");
        }
        return redirect("/erroUsuarioExistente");
    }

    public function listar(){
        $user = \projetoGCA\User::all();
        return view("ListarUsuario", ['listaUsuarios' => $user]); 
    }

    public function cadastrar(){
        return view('CadastroUsuario');
    }

    public function editar($id){
		$user = \projetoGCA\User::find($id);   
    	return view("EditarUsuario", ['user' => $user]);
    }

    public function salvar(Request $request){
        $user = \projetoGCA\User::find($request->id);
        if (($request->email) == $user->email){
            $user->name = $request->name;
            $user->telefone = $request->telefone;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->update();
            return redirect("/listarUsuarios");
        } 
        else if ($this->verificarExistencia($request->email)){
            $user->name = $request->name;
            $user->telefone = $request->telefone;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->update();
            return redirect("/listarUsuarios");
        }
        return redirect("/erroUsuarioExistente");
    }

    public function verificarExistencia($email){
        $user = \projetoGCA\User::where('email','=',$email)->first();
        return empty($user);
    }

}
