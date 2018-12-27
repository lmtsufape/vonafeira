@extends('layouts.app')

@section('titulo','Meus Pedidos')

@section('navbar')
    <a href="/home">Painel</a> > Meus Pedidos
@endsection

@section('content')
  <div class="container">
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                  <div class="panel-heading">Meus Pedidos</div>

                  <div class="panel-body">
                      @if(count($pedidos) == 0)
                      <div class="alert alert-danger">
                              Nenhum pedido realizado.
                      </div>
                      @else
                        <table class="table table-hover">
                            <tr>
                                <th>Cod</th>
                                <th>Número de Itens</th>
                                <th>Total</th>
                                <th>Data</th>
                                <th colspan="2">Ações</th>
                            </tr>
                            @foreach($pedidos as $pedido)
                                <?php
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
                                    <td>{{ $quantidade }}</td>
                                    <td>{{ 'R$'.number_format($valor_pedido, 2) }}</td>
                                    <td>{{ \projetoGCA\Http\Controllers\UtilsController::dataFormato($pedido->data_pedido, 'd/m/Y') }}</td>

                                    <?php
                                      $evento = \projetoGCA\Evento::find($pedido->evento_id);
                                    ?>
                                    @if($evento->estaAberto)
                                      <td><a class="btn btn-info" href="/editarPedido/{{$pedido->id}}">Editar</a></td>
                                    @else
                                      <td><button type="button" class="btn btn-info" disabled>Editar</button></td>
                                    @endif

                                    <td><a class="btn btn-success" href="/meusPedidos/{{$pedido->id}}">Itens</a></td>

                                </tr>
                            @endforeach
                        </table>
                      @endif
                  </div>
              </div>
          </div>
      </div>
  </div>

@endsection
