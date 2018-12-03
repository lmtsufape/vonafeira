@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Itens do Pedido</div>
                <div class="panel-body">
                    <table class="table table-hover"> 
                        <thead>        
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Unidade</th>
                                <th>Preço</th>
                                <th>Preço Total do Item</th>
                            </tr>
                        </thead>
                        @php($total = 0)
                        <tbody>
                        @foreach ($itensPedido as $itemPedido)
                        <tr>
                            <td>{{ $itemPedido->nome_produto }}</td>
                            <td>{{ $itemPedido->quantidades }}</td>
                            <td>{{ $itemPedido->unidade_venda }}</td>
                            <td>{{ 'R$'.number_format($itemPedido->preco, 2) }}</td>
                            <td>{{ 'R$'.number_format($itemPedido->preco * $itemPedido->quantidades, 2) }}</td>
                            @php($total = $total + $itemPedido->preco * $itemPedido->quantidades)
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><strong>Total</strong></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>{{'R$'.number_format($total, 2)}}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="panel-footer">
                    <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection