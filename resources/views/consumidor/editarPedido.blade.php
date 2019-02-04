@extends('layouts.app')

@section('titulo','Editar Pedido')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    <a href="{{ route("consumidor.meusPedidos") }}">Meus Pedidos</a> >
    Editar
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
              <div class="panel panel-default">
                  <div class="panel-heading">Editar Pedido</div>
                  <form class="form-horizontal" method="POST" action="{{ route('consumidor.pedido.atualizar') }}">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <div class="panel-body">

                            <input id="evento_id" type="hidden" class="form-control" name="evento_id" value="{{ $evento->id }}" >

                            <div class="table-responsive">
                              <table class="table table-hover">
                                <tr>
                                    <th>Produto</th>
                                    <th>Descrição</th>
                                    <th>Preço</th>
                                    <th>Quantidade</th>
                                    <th>Unidade</th>
                                    <th>Ação</th>
                                </tr>
                                @php($i = 0)
                                @foreach($itensPedido as $itemPedido)
                                    <?php
                                      $produto = \projetoGCA\Produto::withTrashed()->where('id','=',$itemPedido->produto_id)->first();
                                    ?>

                                    <input id="item_id" type="hidden" class="form-control" name="item_id[{{$i}}]" value="{{ $itemPedido->id }}" >

                                    <tr>
                                        <td>{{ $produto->nome }}</td>
                                        <td>{{ $produto->descricao }}</td>
                                        <td>{{ $produto->preco }}</td>
                                        @if(($produto->unidadeVenda->is_fracionado) == 1)
                                          @if(old('nome',NULL) != NULL)
                                            <td><input id="quantidade" type="number" min="0" step="0.1" class="form-control" name="quantidade[{{$i}}]" value="{{ old('quantidade') }}" autofocus></td>
                                          @else
                                            <td><input id="quantidade" type="number" min="0" step="0.1" class="form-control" name="quantidade[{{$i}}]" value="{{ $itemPedido->quantidade }}" autofocus></td>
                                          @endif
                                        @else
                                          @if(old('nome',NULL) != NULL)
                                            <td><input id="quantidade" type="number" min="0" step="1" class="form-control" name="quantidade[{{$i}}]" value="{{ old('quantidade') }}" autofocus></td>
                                          @else
                                            <td><input id="quantidade" type="number" min="0" step="1" class="form-control" name="quantidade[{{$i}}]" value="{{ $itemPedido->quantidade }}" autofocus></td>
                                          @endif
                                        @endif
                                        <td>{{ $produto->unidadeVenda->nome }}</td>
                                        <td><a onclick="return confirm('Confirmar cancelamento deste item?')" href="{{ route("consumidor.pedido.remover", ["idItemPedido" => $itemPedido->id]) }}" class='btn btn-danger'>Remover</a></td>
                                    </tr>
                                  @php($i++)
                                @endforeach
                              </table>
                            </div>

                      </div>
                      <div class="panel-footer">
                          <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
                      </div>

                  </form>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
