<?php

namespace projetoGCA\Http\Controllers;

use DateTime;
use DateInterval;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \projetoGCA\Produto;
use \projetoGCA\Pedido;
use \projetoGCA\ItemPedido;
use \projetoGCA\Evento;
class PedidoController extends Controller
{

    public function loja(){
        $evento = Evento::where('grupoconsumo_id', '=', Auth::user()->consumidor->grupoConsumo->id)
                                ->where('data_evento', '>', new DateTime())
                                ->where('data_fim_pedidos', '>=', new DateTime())
                                ->orderBy('id', 'DESC')->first();
        $produtos = Produto::all();
        if(!is_null($evento)){
            return view("loja.loja", ['produtos' => $produtos, 'evento' =>$evento]);
        }
        else{
            return view("loja.loja", ['produtos' => array(), 'evento' =>$evento]);
        }

    }
    public function confirmar(Request $request) {
        $input = $request->input();

        $array_of_item_ids = $input['item_id'];
        $quantidades = $input['quantidade'];
        $produtos = Produto::whereIn('id', $array_of_item_ids)->get()->toArray();
        $itens = array();
        $i = 0;
        $total = 0;
        foreach ($produtos as $produto){
            if($quantidades[$i] <= 0){
                unset($quantidades[$i]);
                unset($produtos[$i]);
            }
            else{
                $total += $produtos[$i]['preco']*$quantidades[$i];
            }
            $i = $i + 1;
        }
        $produtos = array_values($produtos);
        $quantidades = array_values($quantidades);
        return view("loja.carrinho", ['produtos' => $produtos, 'quantidades'=>$quantidades, 'total' => $total, 'evento' => $input['evento_id']]);
    }


    public function finalizar(Request $request){
        $input = $request->input();
        $array_of_item_ids = $input['produto_id'];

        $quantidades = $input['quantidade'];

        $produtos = Produto::whereIn('id', $array_of_item_ids)->get();
        $pedido = new Pedido();
        $pedido->consumidor_id = Auth::user()->id;
        $pedido->evento_id = $input['evento_id'];
        $pedido->data_pedido = new DateTime();
        $pedido->is_confirmado = false;
        $pedido->save();
        $itens = array();
        $i = 0;

        $itens_pedido = array();
        foreach ($produtos as $produto){
            if($quantidades[$i] > 0){
                $item = new ItemPedido();
                $item->pedido_id = $pedido->id;
                $item->produto_id = $produto->id;
                $item->quantidade = $quantidades[$i];
                $item->save();
                array_push($itens_pedido,$item);
            }
            $i = $i + 1;
        }

        return redirect("/visualizarPedido/$pedido->id");
    }

    public function visualizar($id){
        $pedido = \projetoGCA\Pedido::find($id);
        $itens_pedido = \projetoGCA\ItemPedido::where('pedido_id','=',$pedido->id)->get();

        return view("loja.pedido", [
            'pedido' => $pedido,
            'itens_pedido' => $itens_pedido]
        );
    }
}
