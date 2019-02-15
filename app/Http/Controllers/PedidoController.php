<?php

namespace projetoGCA\Http\Controllers;

use DateTime;
use DateInterval;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \projetoGCA\Produto;
use \projetoGCA\GrupoConsumo;
use \projetoGCA\Pedido;
use \projetoGCA\Consumidor;
use \projetoGCA\ItemPedido;
use \projetoGCA\Evento;
class PedidoController extends Controller
{

    public function confirmar(Request $request) {
        $input = $request->input();
        
        if(!(array_key_exists("quantidade",$input))){
            return redirect()->back()->with('fail','Necessária a seleção de um ou mais itens.');
        }

        $grupoConsumo = GrupoConsumo::find($input['grupo_consumo_id']);

        $quantidades = $input['quantidade'];
        $array_of_item_ids = array_keys($quantidades);
        
        $thereAre_itens = false;
        
        foreach ($quantidades as $quantidade) {
            //dd($quantidade);
            if($quantidade != 0 && $quantidade != null){
                $thereAre_itens = true;
            }
        }
        
        if(!$thereAre_itens){
            return redirect()->back()->with('fail','Necessário que a quantidade de itens seja superior à 0.');
        }
        
        $produtos = Produto::whereIn('id', $array_of_item_ids)->orderBy('nome')->get();
        $itens = array();
        
        $total = 0;
        $produtos_comprados = [];
        
        foreach($produtos as $produto){
            if($quantidades[$produto->id] <= 0){
                unset($quantidades[$produto->id]);
            }else{
                array_push($produtos_comprados,$produto);
                
                $total += $produto->preco*$quantidades[$produto->id];
            }
        }
        
        $produtos_array = $produtos->toArray();
        /*if(!$is_produtos){
            return back()->withInput();
        }*/

        $produtos = array_values($produtos_comprados);
        $quantidades = array_values($quantidades);
        return view("loja.carrinho", ['grupoConsumo' => $grupoConsumo, 'produtos' => $produtos, 'quantidades'=>$quantidades, 'total' => $total, 'evento' => $input['evento_id']]);
    }


    public function finalizar(Request $request){

        $input = $request->input();
        $array_of_item_ids = $input['produto_id'];

        $quantidades = $input['quantidade'];

        $produtos = Produto::whereIn('id', $array_of_item_ids)->orderBy('nome')->get();
        $pedido = new Pedido();

        $consumidor = Consumidor::where('user_id','=',Auth::user()->id)->where('grupo_consumo_id','=',$input['grupo_id'])->first();
        $pedido->consumidor_id = $consumidor->id;
        $pedido->evento_id = $input['evento_id'];
        $pedido->data_pedido = new DateTime();
        $pedido->localretiradaevento_id = $request->localretiradaevento;
        $pedido->is_confirmado = false;
        $pedido->save();
        $itens = array();
        $i = 0;

        $itens_pedido = array();

        for ($i=0; $i < count($produtos); $i++) {
          if($quantidades[$i] > 0){
              $item = new ItemPedido();
              $item->pedido_id = $pedido->id;
              $item->produto_id = $produtos[$i]->id;
              $item->quantidade = $quantidades[$i];
              $item->save();
              array_push($itens_pedido,$item);
          }
        }

        return redirect("/visualizarPedido/$pedido->id");
    }

    public function visualizar($id){
        $pedido = Pedido::find($id);
        $itens_pedido = ItemPedido::where('pedido_id','=',$pedido->id)->get();

        return view("loja.pedido", [
            'pedido' => $pedido,
            'itens_pedido' => $itens_pedido]
        );
    }
}
