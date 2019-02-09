@extends('layouts.app')

@section('titulo','Listagem de Pedidos')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    <a href="{{ route("grupoConsumo.listar") }}">Grupos de Consumo</a> >
    <a href="{{ route("grupoConsumo.gerenciar", ["id" => $grupoConsumo->id]) }}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> >
    <a href="{{ route("evento.listar", ["idGrupoConsumo" => $grupoConsumo->id]) }}">Eventos</a> >
    Pedidos do Evento {{$evento->id}}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Pedidos</div>
                <div class="panel-body">
                  <div id="tabela" class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Cód.</th>
                          <th>Consumidor</th>
                          <th>Número de Itens</th>
                          <th>Total</th>
                          <th>Data</th>
                          <th>Ações</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($pedidos as $pedido)
                          <?php
                            $consumidor = \projetoGCA\User::find($pedido->consumidor->user_id);
                            $quantidade = 0;
                            $valor_pedido = 0;
                            $itens_pedido = \projetoGCA\ItemPedido::where('pedido_id','=',$pedido->id)->get();
                            foreach($itens_pedido as $item_pedido){
                              $produto = \projetoGCA\Produto::withTrashed()->find($item_pedido->produto_id);
                              $valor_pedido = $valor_pedido + $item_pedido->quantidade * $produto->preco;
                              $quantidade = $quantidade + 1;
                            }
                          ?>
                          <tr>
                            <td data-title="Cód.">{{ $pedido->id }}</td>
                            <td data-title="Consumidor">{{ $consumidor->name }}</td>
                            <td data-title="Número de Itens">{{ $quantidade }}</td>
                            <td data-title="Total">{{ 'R$ '.number_format($valor_pedido, 2) }}</td>
                            <td data-title="Data">{{ \projetoGCA\Http\Controllers\UtilsController::dataFormato($pedido->data_pedido, 'd/m/Y') }}</td>
                            <td>
                              <a class="btn btn-info" href="{{ route("evento.pedido.itens", ["pedido_id" => $pedido->id]) }}">
                                Itens
                              </a>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="panel-footer">

                    <a class="btn btn-danger" href="{{ route("evento.listar", ["idGrupoConsumo" => $grupoConsumo->id]) }}">
                      Voltar
                    </a>
                    @if($evento->estaAberto)
                        <a class="btn btn-primary" disabled>Relatório Montagem Pedido</a>
                        <a class="btn btn-primary" disabled>Relatório Produtor</a>
                        <a class="btn btn-primary" disabled>Relatório Consumidor</a>
                    @else
                        <a class="btn btn-primary" target="_blank" href="{{ route("evento.relatorio.montagem", ["evento_id" => $evento->id]) }}">
                          Relatório Montagem Pedido
                        </a>
                        <a class="btn btn-primary" target="_blank" href="{{ route("evento.relatorio.produtores", ["evento_id" => $evento->id]) }}">
                          Relatório Produtores
                        </a>
                        <a class="btn btn-primary" target="_blank" href="{{ route("evento.relatorio.consumidores", ["evento_id" => $evento->id]) }}">
                          Relatório Consumidores
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
