<?php

namespace projetoGCA\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{
    public function criarRelatorioPedidosProdutores($evento_id){
        $view = 'relatorios.pedidosProdutores';

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
        $view = \View::make($view, compact('date', 'itensPedidos', 'produtores', 'produtos'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $evento = \projetoGCA\Evento::find($evento_id);
        $filename = 'RelatorioProdutores_Grupo'.$evento->grupoconsumo_id.'_Evento'.$evento->id.'_'.$date;
        return $pdf->stream($filename.'afsaf.pdf');
    }

    public function criarRelatorioMontagemPedidos($evento_id){
        $view = 'relatorios.composicaoPedidos';

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
        $view = \View::make($view, compact('data', 'produtos','pedidos','itensPedido'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $evento = \projetoGCA\Evento::find($evento_id);
        $filename = 'RelatorioMontagem_Grupo'.$evento->grupoconsumo_id.'_Evento'.$evento->id.'_'.$data;
        return $pdf->stream($filename.'.pdf');

    }

    public function criarRelatorioPedidosConsumidores($evento_id){
        $view = 'relatorios.pedidosConsumidores';

        $pedidos = \projetoGCA\Pedido::where('evento_id','=',$evento_id)->get();

        $consumidores = array();
        foreach ($pedidos as $pedido) {
            $consumidor = \projetoGCA\User::find($pedido->consumidor->user_id);
            if(!(in_array($consumidor,$consumidores))){
                array_push($consumidores,$consumidor);
            }
        }

        $data = date('d/m/Y');
        $view = \View::make($view, compact('data', 'consumidores','pedidos'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $evento = \projetoGCA\Evento::find($evento_id);
        $filename = 'RelatorioConsumidores_Grupo'.$evento->grupoconsumo_id.'_Evento'.$evento->id.'_'.$data;
        return $pdf->stream($filename.'.pdf');
    }

    public function downloadRelatorioPedidosProdutores($evento_id){
        $view = 'relatorios.pedidosProdutores';

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
        $view = \View::make($view, compact('date', 'itensPedidos', 'produtores', 'produtos'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $evento = \projetoGCA\Evento::find($evento_id);
        $filename = 'RelatorioProdutores_Grupo'.$evento->grupoconsumo_id.'_Evento'.$evento->id.'_'.$date;
        return $pdf->download($filename.'.pdf');
    }

    public function downloadRelatorioMontagemPedidos($evento_id){
        $view = 'relatorios.composicaoPedidos';

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
        $view = \View::make($view, compact('data', 'produtos','pedidos','itensPedido'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $evento = \projetoGCA\Evento::find($evento_id);
        $filename = 'RelatorioMontagem_Grupo'.$evento->grupoconsumo_id.'_Evento'.$evento->id.'_'.$data;
        return $pdf->download($filename.'.pdf');

    }

    public function downloadRelatorioPedidosConsumidores($evento_id){
        $view = 'relatorios.pedidosConsumidores';

        $pedidos = \projetoGCA\Pedido::where('evento_id','=',$evento_id)->get();

        $consumidores = array();
        foreach ($pedidos as $pedido) {
            $consumidor = \projetoGCA\User::find($pedido->consumidor->user_id);
            if(!(in_array($consumidor,$consumidores))){
                array_push($consumidores,$consumidor);
            }
        }

        $data = date('d/m/Y');
        $view = \View::make($view, compact('data', 'consumidores','pedidos'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $evento = \projetoGCA\Evento::find($evento_id);
        $filename = 'RelatorioConsumidores_Grupo'.$evento->grupoconsumo_id.'_Evento'.$evento->id.'_'.$data;
        return $pdf->download($filename.'.pdf');
    }

    public function criarRelatorioPedidoCliente($evento_id){
      $view = 'relatorio.pedidoCliente';
      $data = \projetoGCA\Pedido::where('evento_id', '=', $evento_id)->get();
      $evento = \projetoGCA\Evento::find($evento_id);

      $date = date('d/m/Y');
      $view = \View::make($view, compact('data', 'date','evento'))->render();
      $pdf = \App::make('dompdf.wrapper');
      $pdf->loadHTML($view);
      return $pdf->stream('relatorio.pdf');
    }

    public function termosDeUso(){
        $view = 'termosDeUso';

        $view = \View::make($view, compact('data', 'date','evento'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('termosDeUso.pdf');
    }
}
