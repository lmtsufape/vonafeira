@extends('layouts.app')

@section('titulo','Listagem de Pedido')

@section('navbar')
    <a href="/home">Início</a> >
    <a href="/meusPedidos">Meus Pedidos</a> >
    Itens do Pedido
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Itens do Pedido</div>
                <div class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Descrição</th>
                                <th>Produtor</th>
                                <th>Quantidade</th>
                                <th>Unidade</th>
                                <th>Preço</th>
                                <th>Preço Total do Item</th>
                            </tr>
                        </thead>
                        @php($total = 0)
                        <tbody>
                        @foreach ($itensPedido as $itemPedido)
                          <?php
                            $produto = \projetoGCA\Produto::withTrashed()->where('id','=',$itemPedido->produto_id)->first();
                            $unidadeVenda = \projetoGCA\UnidadeVenda::where('id','=',$produto->unidadevenda_id)->first();
                            $produtor = \projetoGCA\Produtor::withTrashed()->where('id','=',$produto->produtor_id)->first();
                          ?>
                          <tr>
                              <td>{{ $produto->nome}}</td>
                              <td>{{ $produto->descricao}}</td>
                              <td>{{ $produtor->nome}}</td>
                              <td>{{ $itemPedido->quantidade }}</td>
                              <td>{{ $unidadeVenda->nome}}</td>
                              <td>{{ 'R$ '.number_format($produto->preco, 2) }}</td>
                              <td>{{ 'R$ '.number_format($produto->preco * $itemPedido->quantidade, 2) }}</td>
                              @php($total = $total + $produto->preco * $itemPedido->quantidade)
                          </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>

                                <th colspan="5"></th>
                                <th><strong>Total</strong></th>
                                <th>{{'R$ '.number_format($total, 2)}}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                  </div>
                </div>
                <div class="panel-footer">
                    <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
