@extends('layouts.app')

@section('titulo','Finalizado')

@section('content')

<div class="container">
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="7">{{'Pedido #'.$pedido->id}}</th>
            </tr>
            <tr>
                <th>Produto</th>
                <th>Descrição</th>
                <th>Produtor</th>
                <th>Quantidade</th>
                <th>Un. Venda</th>
                <th>Preço Un.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php($total = 0)
            @foreach($itens_pedido as $item)

                <tr>
                    <?php
                        $produto = $item->produto;
                        $unidadeVenda = $produto->unidadeVenda;
                        $total_item = $produto->preco * $item->quantidade;
                        $total = $total + $total_item
                    ?>
                    <td>{{$produto->nome}}</td>
                    <td>{{$produto->descricao}}</td>
                    <td>{{$produto->produtor->nome}}</td>
                    <td>{{$item->quantidade}}</td>
                    <td>{{$unidadeVenda->nome}}</td>
                    <td>{{'R$ '.number_format($produto->preco,2)}}</td>
                    <td>{{'R$ '.number_format($total_item,2)}}</td>
                </tr>

            @endforeach

        </tbody>
        <tfoot>
            <tr>
                <th colspan="7" style="text-align: right">Total: {{'R$ '.number_format($total,2)}}</th>
            </tr>
        </tfoot>
      </table>
    </div>

    <a href="/" class='btn btn-primary'>Início</a>
    <a href="/editarPedido/{{$pedido->id}}" class='btn btn-primary'>Editar Pedido</a>
    <a href="/meusPedidos" class='btn btn-primary'>Meus Pedidos</a>
</div>


@endsection
