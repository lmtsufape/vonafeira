<?php

namespace projetoGCA\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class GrupoConsumoController extends Controller
{

    public function novo(){
        $estados = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];
        $periodos = ['Semanal','Quinzenal','Mensal','Bimestral'];
        $dias = ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'];
        $prazos_pedido = [1,2,3,4,5,6];

        return view(
            "grupoConsumo.adicionarGrupoConsumo",
            ['estados' => $estados,
            'periodos' => $periodos,
            'dias' => $dias,
            'prazos_pedido' => $prazos_pedido]
        );
    }

    public function cadastrar(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:grupo_consumos|min:3|max:50',
            'descricao' => 'max:300',
            'periodo' => 'required',
            'dia_semana' => 'required',
            'prazo_pedidos' => 'required',
            'estado' => 'required|min:2',
            'localidade'=>'required|min:2',
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
        $grupoConsumo->estado = $request->estado;
        $grupoConsumo->cidade = $request->localidade;
        $grupoConsumo->save();

        ConsumidorController::cadastrarCoordenador($grupoConsumo->id, $grupoConsumo->coordenador_id);

        // Redireciona para a listagem de grupo de Consumos, passando o nome do grupo que foi cadastrado
        return redirect()
                ->action('GrupoConsumoController@listar')
                ->withInput();
    }

    public function editar($id) {
        $estados = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($id);
        return view("grupoConsumo.editarGrupoConsumo", [
            'grupoConsumo' => $grupoConsumo,
            'estados' => $estados]
        );
    }

    public function atualizar(Request $request){
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($request->id);

        if($grupoConsumo->name == $request->name){

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3|max:50',
                'descricao' => 'max:300',
                'periodo' => 'required',
                'dia_semana' => 'required',
                'prazo_pedidos' => 'required',
                'estado' => 'required|min:2',
                'localidade'=>'required|min:2',
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

        }else{

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:grupo_consumos|min:3|max:50',
                'descricao' => 'max:300',
                'periodo' => 'required',
                'dia_semana' => 'required',
                'prazo_pedidos' => 'required',
                'estado' => 'required|min:2',
                'localidade'=>'required|min:2',
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            $grupoConsumo->name = $request->name;

        }

        $grupoConsumo->descricao = $request->descricao;
            $grupoConsumo->periodo = $request->periodo;
            $grupoConsumo->dia_semana = $request->dia_semana;
            $grupoConsumo->prazo_pedidos = $request->prazo_pedidos;
            $grupoConsumo->estado = $request->estado;
            $grupoConsumo->cidade = $request->localidade;
            $grupoConsumo->update();

            return redirect("/gerenciar/$grupoConsumo->id");

    }


    public function listar(){
        if(Auth::check()){
            $gruposConsumo = \projetoGCA\GrupoConsumo::where('coordenador_id', '=', Auth::user()->id)->get();

            $gruposConsumoParticipante = \projetoGCA\GrupoConsumo::whereHas('consumidores', function($query){
                $query->where('user_id', '=', Auth::user()->id);
            })->orderBy('name')->get();

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

    public function sair($grupoConsumoId){
        $userId = \Auth::User()->id;
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($grupoConsumoId);
        $consumidor = \projetoGCA\Consumidor::where('user_id','=',$userId)->where('grupo_consumo_id','=',$grupoConsumo->id)->first();
        $consumidor->delete();
        return back()->with('success',('Você saiu do grupo: '.$grupoConsumo->name));
    }

    public function compartilhar($grupoConsumoId){
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($grupoConsumoId);
        $coordenador = \projetoGCA\User::find($grupoConsumo->coordenador_id);

        $user = \Auth::user();
        $user_already_in = 0; //false
        if($user->id == $coordenador->id){
            $user_already_in = 1; //true, coordenador
        }else{
            foreach($grupoConsumo->consumidores as $consumidor){
                if($user->id == $consumidor->user_id){
                    $user_already_in = 2; //true, consumidor
                }
            }
        }

        return view("grupoConsumo.compartilhar", [
            'user_in' => $user_already_in,
            'grupoConsumo' => $grupoConsumo,
            'coordenador' => $coordenador,]
        );
    }
}
