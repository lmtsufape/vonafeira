<?php

namespace projetoGCA\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class GrupoConsumoController extends Controller
{

    public function novo(){
        return view("grupoConsumo.adicionarGrupoConsumo");
    }

    public function cadastrar(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:grupo_consumos|min:3|max:50',
            'descricao' => 'min:0',
            'periodo' => 'required',
            'dia_semana' => 'required',
            'prazo_pedidos' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $grupoConsumo = new \projetoGCA\GrupoConsumo();
        $grupoConsumo->name = $request->name;
        $grupoConsumo->descricao = $request->descricao;
        $grupoConsumo->periodo = $request->periodo;
        $grupoConsumo->dia_semana = $request->dia_semana;
        $grupoConsumo->prazo_pedidos = $request->prazo_pedidos;
        $grupoConsumo->coordenador_id = Auth::user()->id;
        $grupoConsumo->save();
        // Redireciona para a listagem de grupo de Consumos, passando o nome do grupo que foi cadastrado
        return redirect()
                ->action('GrupoConsumoController@listar')
                ->withInput();
    }

    public function editar($id) {
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($id);
        return view("grupoConsumo.editarGrupoConsumo", ['grupoConsumo' => $grupoConsumo]);
    }

    public function atualizar(Request $request){

        $grupoConsumo = \projetoGCA\GrupoConsumo::find($request->id);
        if($grupoConsumo->nome == $request->nome){
            $grupoConsumo->name = $request->name;
            $grupoConsumo->descricao = $request->descricao;
            $grupoConsumo->periodo = $request->periodo;
            $grupoConsumo->dia_semana = $request->dia_semana;
            $grupoConsumo->prazo_pedidos = $request->prazo_pedidos;
            $grupoConsumo->update();

            return redirect()
                    ->action('GrupoConsumoController@listar');
        }
        else if($this->verificarExistencia($request->nome) ){
            $grupoConsumo->name = $request->name;
            $grupoConsumo->descricao = $request->descricao;
            $grupoConsumo->periodo = $request->periodo;
            $grupoConsumo->dia_semana = $request->dia_semana;
            $grupoConsumo->prazo_pedidos = $request->prazo_pedidos;
            $grupoConsumo->update();

            return redirect()->action('GrupoConsumoController@listar');
        }
        return redirect("/erroCadastroExiste");
    }


    public function listar(){
        if(Auth::check()){
            $gruposConsumo = \projetoGCA\GrupoConsumo::where('coordenador_id', '=', Auth::user()->id)->get();

            $gruposConsumoParticipante = \projetoGCA\GrupoConsumo::whereHas('consumidores', function($query){
                $query->where('user_id', '=', Auth::user()->id);
            })->get();

            return view("grupoConsumo.gruposConsumo", ['gruposConsumo' => $gruposConsumo,
                                                       'gruposConsumoParticipante' => $gruposConsumoParticipante]);
        }
        return view("/home");
    }

    public function listarGrupos(){
        if(Auth::check()){
            $gruposConsumo = \projetoGCA\GrupoConsumo::all();
        }
        return $grupoConsumo;
    }

    public function gerenciar($idGrupoConsumo){
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($idGrupoConsumo);
        return view("grupoConsumo.gerenciarGrupo", ['grupoConsumo' => $grupoConsumo]);
    }
}
