<?php

namespace projetoGCA\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use \projetoGCA\Consumidor;
use \projetoGCA\Pedido;
use \projetoGCA\ItemPedido;
use \projetoGCA\User;
use \projetoGCA\Evento;
use \projetoGCA\GrupoConsumo;
class ConsumidorController extends Controller
{
    /**
     * @Deprecated
     */
    public function adicionar(){
        $user = User::all();
        $grupoConsumo = GrupoConsumo::all();
        return view("consumidor.adicionarConsumidor", ['users' => $user], ['gruposConsumo' => $grupoConsumo]);
    }

    public function cadastrar(Request $request){

        $query = Consumidor::where([
                          ['grupo_consumo_id', '=', $request->grupoConsumo],
                          ['user_id', '=', Auth::user()->id]
                        ])->first();

        if(is_null($query)){
          $consumidor = new Consumidor();
          $consumidor->user_id = Auth::user()->id;
          $consumidor->grupo_consumo_id = $request->grupoConsumo;
          $consumidor->save();
        }
        return redirect("/home");

    }

    public static function cadastrarCoordenador($idGrupoConsumo, $idCoordenador){

        $query = Consumidor::where([
                          ['grupo_consumo_id', '=', $idGrupoConsumo],
                          ['user_id', '=', $idCoordenador]
                        ])->first();

        if(is_null($query)){
          $consumidor = new Consumidor();
          $consumidor->user_id = $idCoordenador;
          $consumidor->grupo_consumo_id = $idGrupoConsumo;
          $consumidor->save();
        }
    }

    public function listar($idGrupoConsumo){
        if(Auth::check()){
            $grupoConsumo = GrupoConsumo::find($idGrupoConsumo);
            $consumidores = Consumidor::where('grupo_consumo_id', '=', $idGrupoConsumo)->get();
            return view(
                "consumidor.consumidores",
                ['consumidores' => $consumidores,
                'grupoConsumo' => $grupoConsumo]
            );
        }
        return view("/home");
    }

    public function selecionarGrupo(){

        $gruposConsumoTodos = GrupoConsumo::all();

        $gruposConsumoParticipante = GrupoConsumo::whereHas('consumidores', function($query){
            $query->where('user_id', '=', Auth::user()->id);
        })->get();

        $gruposConsumo = $gruposConsumoTodos->diff($gruposConsumoParticipante);

        return view('consumidor.selecionarGrupo',
                   ['gruposConsumo' => $gruposConsumo]);
    }

    public function pedidos(){
      $consumidores = Auth::user()->consumidores;

      $subset = $consumidores->map(function ($consumidor) {
          return collect($consumidor->toArray())
               ->only(['id'])
               ->all();
      });

      $pedidos = Pedido::whereIn('consumidor_id', $subset)
                       ->orderBy('data_pedido', 'ASC')->get();

      return view('consumidor.meusPedidos', ['pedidos'=>$pedidos]);
    }

    public function itensPedido($pedido_id){

        $pedido = \projetoGCA\Pedido::find($pedido_id);
        $itens = $pedido->itens;

        return view('consumidor.meusItensPedido', ['itensPedido' => $itens]);
    }


    public function editarPedido($idPedido){
      $pedido = Pedido::find($idPedido);
      $evento = Evento::find($pedido->evento_id);
      $itensPedido = ItemPedido::where('pedido_id','=',$pedido->id)->get();

      return view("consumidor.editarPedido", [
          'pedido' => $pedido,
          'evento' => $evento,
          'itensPedido' => $itensPedido]
      );
    }

    public function removerPedido($idItemPedido){

      $itemPedido = \projetoGCA\ItemPedido::find($idItemPedido);
      $pedido = Pedido::where('id','=',$itemPedido->pedido_id)->first();

      $itemPedido->delete();

      $evento = Evento::find($pedido->evento_id);
      $itensPedido = ItemPedido::where('pedido_id','=',$pedido->id)->get();

      if(count($itensPedido) == 0){
        $pedido->delete();
        return redirect("/meusPedidos");
      }else{
        return redirect("/editarPedido/$pedido->id");
      }

    }

    public function atualizarPedido(Request $request){
      $input = $request->input();
      $array_of_item_ids = $input['item_id'];
      $quantidades = $input['quantidade'];

      $itensPedido = ItemPedido::whereIn('id', $array_of_item_ids)->get();

      $i = 0;

      foreach ($itensPedido as $item){
          if($quantidades[$i] > 0){
              $item->quantidade = $quantidades[$i];
              $item->update();
          }
          $i = $i + 1;
      }

      return redirect("/meusPedidos");
    }

}
