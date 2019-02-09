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

                    <div id="tabela" class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                              <th>Produto</th>
                              <th>Descrição</th>
                              <th>Preço</th>
                              <th>Quantidade</th>
                              <th>Unidade</th>
                              <th>Ação</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php($i = 0)
                          @foreach($itensPedido as $itemPedido)
                              <?php
                                $produto = \projetoGCA\Produto::withTrashed()->where('id','=',$itemPedido->produto_id)->first();
                              ?>

                              <input id="item_id" type="hidden" class="form-control" name="item_id[{{$i}}]" value="{{ $itemPedido->id }}" >

                              <tr>
                                  <td data-title="Produto">{{ $produto->nome }}</td>
                                  <td data-title="Descrção">{{ $produto->descricao }}</td>
                                  <td data-title="Preço">{{ $produto->preco }}</td>
                                  @if(($produto->unidadeVenda->is_fracionado) == 1)
                                    @if(old('nome',NULL) != NULL)
                                      <td data-title="Quantidade"><input id="quantidade" type="number" min="0" step="0.1" class="form-control" name="quantidade[{{$i}}]" value="{{ old('quantidade') }}" autofocus></td>
                                    @else
                                      <td data-title="Quantidade"><input id="quantidade" type="number" min="0" step="0.1" class="form-control" name="quantidade[{{$i}}]" value="{{ $itemPedido->quantidade }}" autofocus></td>
                                    @endif
                                  @else
                                    @if(old('nome',NULL) != NULL)
                                      <td data-title="Quantidade"><input id="quantidade" type="number" min="0" step="1" class="form-control" name="quantidade[{{$i}}]" value="{{ old('quantidade') }}" autofocus></td>
                                    @else
                                      <td data-title="Quantidade"><input id="quantidade" type="number" min="0" step="1" class="form-control" name="quantidade[{{$i}}]" value="{{ $itemPedido->quantidade }}" autofocus></td>
                                    @endif
                                  @endif
                                  <td data-title="Unidade">{{ $produto->unidadeVenda->nome }}</td>
                                  <td data-title="Ação"><a onclick="return confirm('Confirmar cancelamento deste item?')" href="{{ route("consumidor.pedido.remover", ["idItemPedido" => $itemPedido->id]) }}" class='btn btn-danger'>Remover</a></td>
                              </tr>
                            @php($i++)
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="panel-footer">
                      <div class="form-group">
                        <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>

                        <button type="submit" class="btn btn-primary">
                            Atualizar Pedido
                        </button>
                      </div>
                  </div>
                </form>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
