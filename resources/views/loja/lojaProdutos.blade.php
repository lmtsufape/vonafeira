@extends('layouts.app')

@section('navbar')
  <a href="/home">Início</a> >
  <a href="/loja">Loja</a> > Evento em: {{$grupoConsumo->name}}
@endsection

@section('titulo','Loja')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Produtos</div>
                <form class="form-horizontal" method="POST" action="{{action('PedidoController@confirmar')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="panel-body">
                        @if (\Session::has('fail'))
                        <br>
                            <div class="alert alert-danger">
                                <strong>Erro!</strong>
                                {!! \Session::get('fail') !!}
                            </div>
                        @endif
                        @if(count($produtos) == 0)
                          <div class="alert alert-danger">
                            Não existem produtos disponíveis no momento.
                          </div>
                        @else
                          <input id="evento_id" type="hidden" class="form-control" name="evento_id" value="{{ $evento->id }}" >
                          <input id="grupo_consumo_id" type="hidden" class="form-control" name="grupo_consumo_id" value="{{ $grupoConsumo->id }}" >
                          <div class="table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Preço</th>
                                    <th>Quantidade</th>
                                    <th>Unidade</th>
                                </tr>

                                @foreach($produtos as $produto)
                                <input id="item_id" type="hidden" class="form-control" name="item_id[{{$produto->id}}]" value="{{ $produto->id }}" >
                                <tr>
                                    <td>{{ $produto->nome }}</td>
                                    <td>{{ $produto->descricao }}</td>
                                    <td>{{ 'R$ '.number_format($produto->preco,2)}}</td>
                                    @if(($produto->unidadeVenda->is_fracionado) == 1)
                                        <td><input id="quantidade" type="number" min="0" step="0.1" class="form-control" name="quantidade[{{$produto->id}}]" value="{{ old('quantidade') }}" autofocus></td>
                                    @else
                                        <td><input id="quantidade" type="number" min="0" step="1" class="form-control" name="quantidade[{{$produto->id}}]" value="{{ old('quantidade') }}" autofocus></td>
                                    @endif
                                    <td>{{ $produto->unidadeVenda->nome }}</td>
                                </tr>

                                @endforeach
                            </table>
                          <div class="table-responsive">

                    </div>
                    <div class="panel-footer">
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-13">
                                <button type="submit" class="btn btn-primary">
                                    Adicionar ao Carrinho
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
