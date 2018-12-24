@extends('layouts.app')

@section('titulo','Listagem de Pedidos')

@section('navbar')
    <a href="/home">Painel</a> > <a href="/gruposConsumo">Grupos de Consumo</a> > <a href="/gerenciar/{{$grupoConsumo->id}}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> > <a href="/eventos/{{$grupoConsumo->id}}">Eventos</a> > Pedidos do Evento {{$evento->id}}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Pedidos</div>
                <div class="panel-body">
                <table class="table table-hover">
                    <tr>
                        <th>Cod</th>
                        <th>Consumidor</th>
                        <th>Número de Itens</th>
                        <th>Total</th>
                        <th>Data</th>
                        <th colspan="2">Ações</th>
                    </tr>
                    @foreach($pedidos as $pedido)
                        <?php
                            $user = \projetoGCA\User::find($pedido->consumidor_id);
                            $quantidade = 0;
                            $valor_pedido = 0;
                            $itens_pedido = \projetoGCA\ItemPedido::where('pedido_id','=',$pedido->id)->get();
                            foreach($itens_pedido as $item_pedido){
                                $produto = \projetoGCA\Produto::find($item_pedido->produto_id);
                                $valor_pedido = $item_pedido->quantidade * $produto->preco;
                                $quantidade = $quantidade + $item_pedido->quantidade;
                            }
                        ?>
                        <tr>
                            <td>{{ $pedido->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $quantidade }}</td>
                            <td>{{ 'R$'.number_format($valor_pedido, 2) }}</td>
                            <td>{{ \projetoGCA\Http\Controllers\UtilsController::dataFormato($pedido->data_pedido, 'd/m/Y') }}</td>
                            <td><a class="btn btn-info" href="{{action('EventoController@itensPedido', $pedido->id)}}">Itens</a></td>
                        </tr>
                    @endforeach
                </table>
                </div>
                <div class="panel-footer">
                    <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
                    @if($evento->estaAberto)
                        <a class="btn btn-primary" disabled>Relatório Montagem Pedido</a>
                        <a class="btn btn-warning" disabled>Relatório Produtor</a>
                    @else
                        <a class="btn btn-primary" target="_blank" href="{{action('PdfController@criarRelatorioComposicaoPedidos', $evento_id)}}">Relatório Montagem Pedido</a>
                        <a class="btn btn-warning" target="_blank" href="{{action('PdfController@criarRelatorioPedidosProdutores', $evento_id)}}">Relatório Produtor</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
