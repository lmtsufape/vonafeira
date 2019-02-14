<?php

namespace projetoGCA\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanilhaController extends Controller
{

    public function criarRelatorioPedidosProdutores($evento_id){
        $view = 'relatoriosPlanilha.pedidosProdutores';

        $itensPedidos = \projetoGCA\ItemPedido::whereHas('pedido', function ($query) use($evento_id){
            $query->where('evento_id', '=', $evento_id);
        })->get();

        $produtores = array();
        foreach ($itensPedidos as $itemPedido) {
            $ṕroduto = $itemPedido->produto()->withTrashed()->first();
            $produtor = $ṕroduto->produtor()->withTrashed()->first();

            if(!in_array($produtor,$produtores)){
                array_push($produtores,$produtor);
            }
        }

        $produtos = array();
        foreach ($itensPedidos as $itemPedido) {
            $produto = $itemPedido->produto()->withTrashed()->first();

            if(!in_array($produto,$produtos)){
                array_push($produtos,$produto);
            }
        }

        $date = date('d/m/Y');

        $evento = \projetoGCA\Evento::find($evento_id);
        $filename = 'RelatorioProdutores_Grupo'.$evento->grupoconsumo_id.'_Evento'.$evento->id.'_'.$date;
        \Excel::create($filename, function($excel) use ($view, $evento_id, $date, $itensPedidos, $produtores, $produtos){

            $excel->sheet('Evento '.$evento_id, function($sheet) use ($view, $date, $itensPedidos, $produtores, $produtos){

                $sheet->loadView($view, array('date' => $date,
                                              'itensPedidos' => $itensPedidos,
                                              'produtores' => $produtores,
                                              'produtos' => $produtos));
            });

        })->download('xls');
    }

    public function criarRelatorioMontagemPedidos($evento_id){
        $view = 'relatoriosPlanilha.composicaoPedidos';

        $produtos = \projetoGCA\Produto::withTrashed()->get()->sortBy('nome');
        $pedidos = \projetoGCA\Pedido::where('evento_id','=',$evento_id)->get();

        $itensPedido = \projetoGCA\ItemPedido::whereHas('pedido', function ($query) use($evento_id){
            $query->where('evento_id', '=', $evento_id);
        })->orderBy('produto_id')->get();

        $produtos_array = array();
        foreach($produtos as $produto){
            foreach ($itensPedido as $itemPedido) {
                if($itemPedido->produto()->withTrashed()->first()->id == $produto->id){
                    if(!in_array($produto,$produtos_array)){
                        array_push($produtos_array,$produto);
                    }
                }
            }
        }

        $data = date('d/m/Y');

        $evento = \projetoGCA\Evento::find($evento_id);
        $filename = 'RelatorioProdutores_Grupo'.$evento->grupoconsumo_id.'_Evento'.$evento->id.'_'.$data;
        \Excel::create($filename, function($excel) use ($view, $evento_id, $data, $produtos, $pedidos, $itensPedido){

            $excel->sheet('Evento '.$evento_id, function($sheet) use ($view, $data, $produtos, $pedidos, $itensPedido){

                $sheet->loadView($view, array('data' => $data,
                                              'produtos' => $produtos,
                                              'pedidos' => $pedidos,
                                              'itensPedido' => $itensPedido));

            });

        })->download('xls');

    }

    public function criarRelatorioPedidosConsumidoresExcel($evento_id){
        $view = 'relatoriosPlanilha.pedidosConsumidores';

        $pedidos = \projetoGCA\Pedido::where('evento_id','=',$evento_id)->get();

        $consumidores = array();
        foreach ($pedidos as $pedido) {
            $consumidor = \projetoGCA\User::find($pedido->consumidor->user_id);
            if(!(in_array($consumidor,$consumidores))){
                array_push($consumidores,$consumidor);
            }
        }
        $data = date('d/m/Y');

        $evento = \projetoGCA\Evento::find($evento_id);
        $filename = 'RelatorioProdutores_Grupo'.$evento->grupoconsumo_id.'_Evento'.$evento->id.'_'.$data;
        \Excel::create($filename, function($excel) use ($view, $evento_id, $data, $consumidores, $pedidos){

            $excel->sheet('Evento '.$evento_id, function($sheet) use ($view, $data, $consumidores, $pedidos){

                $sheet->loadView($view, array('data' => $data,
                                              'consumidores' => $consumidores,
                                              'pedidos' => $pedidos));
            });

        })->download('xls');
    }
}
