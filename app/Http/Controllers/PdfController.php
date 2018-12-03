<?php

namespace projetoGCA\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PdfController extends Controller
{
    public function criarPdf($dados, $view){
        $data = $dados;
        $date = date('d/m/Y');
        $view = \View::make($view, compact('data', 'date'))->render();
        $pdf = \App::make('dompdf.wrapper');


        return $pdf->stream('relatorio');
    }

    public function criarRelatorioPedidosProdutores($evento_id){
        $view = 'relatorios.pedidosProdutores';
        $data = DB:: select("select * from item_pedidos where pedido_id in (select pedidos.id from pedidos where evento_id = ".$evento_id.")  order by nome_produtor");
        $produtores = DB:: select("select nome_produtor from item_pedidos where pedido_id in (select pedidos.id from pedidos where evento_id = ".$evento_id.") group by nome_produtor order by nome_produtor");
        //return var_dump($produtores[0]->nome_produtor);

        $date = date('d/m/Y');
        $view = \View::make($view, compact('data', 'date',' produtores'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('relatorio');

        //return view($view, ['data'=>$data, 'date'=>$date]);
    }


    public function criarRelatorioComposicaoPedidos($evento_id){
        $view = 'relatorios.composicaoPedidos';
        $data = \projetoGCA\Pedido::where('evento_id', '=', $evento_id)->get();
        $evento = \projetoGCA\Evento::find($evento_id);
        //return var_dump($produtores[0]->nome_produtor);

        $date = date('d/m/Y');
        $view = \View::make($view, compact('data', 'date','evento'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('relatorio');

        //return view($view, ['data'=>$data, 'date'=>$date]);
    }
    public function criarRelatorioPedidoCliente($evento_id){
      $view = 'relatorio.pedidoCliente';
      $data = \projetoGCA\Pedido::where('evento_id', '=', $evento_id)->get();
      $evento = \projetoGCA\Evento::find($evento_id);

      $date = date('d/m/Y');
      $view = \View::make($view, compact('data', 'date','evento'))->render();
      $pdf = \App::make('dompdf.wrapper');
      $pdf->loadHTML($view);
      return $pdf->stream('relatorio');
    }
}
