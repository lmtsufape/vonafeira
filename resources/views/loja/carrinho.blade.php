@extends('layouts.app')

@section('navbar')
  <a href="{{ route("home") }}">Início</a> >
  <a href="{{ route("loja") }}">Loja</a> >
  <a href="{{ route("loja.evento", ["id" => $evento]) }}">Evento em: {{$grupoConsumo->name}}</a> >
  Carrinho
@endsection

@section('titulo','Carrinho')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Finalizar Pedido</strong></div>
                <form class="form-horizontal" method="POST" action="{{ route("pedido.finalizar") }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input id="evento_id" type="hidden" class="form-control" name="evento_id" value="{{ $evento }}" >
                    <input id="grupo_id" type="hidden" class="form-control" name="grupo_id" value="{{ $grupoConsumo->id }}" >
                <div class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>

                            <th>Produto</th>
                            <th>Descrição</th>
                            <th>Quantidade</th>
                            <th>Unidade de Venda</th>
                            <th>Preço</th>
                            <th>Produtor</th>
                        </thead>
                        <tfoot>
                            <tr>
                                <th colspan="5" style="text-align: right">Total</th>
                                <th>{{'R$ '.number_format($total,2)}}</th>
                            </tr>
                        </tfoot>
                            @for ($i = 0; $i < count($quantidades); $i++)
                            <input id="produto_id" type="hidden" class="form-control" name="produto_id[{{$i}}]" value="{{ $produtos[$i]['id'] }}" >
                            <input id="quantidade[{{$i}}]" type="hidden" class="form-control" name="quantidade[{{$i}}]" value="{{ $quantidades[$i] }}" >
                            <tr>
                                <td>{{ $produtos[$i]['nome'] }}</td>
                                <td>{{ $produtos[$i]['descricao'] }}</td>
                                <td>{{ $quantidades[$i] }}</td>
                                <td>{{\projetoGCA\UnidadeVenda::find($produtos[$i]['unidadevenda_id'])->nome }}</td>
                                <td>{{ 'R$ '.number_format($produtos[$i]['preco']*$quantidades[$i],2) }}</td>
                                <td>{{\projetoGCA\Produtor::find($produtos[$i]['produtor_id'])->nome}}</td>
                            </tr>
                            @endfor
                    </table>
                  </div>
                </div>
                    <div class="panel-footer">
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-13">

                                <select class="form-control" name="localretiradaevento" required>
                                    <option value="" selected disabled hidden>Escolha local de retirada</option>
                                    @php($evento = \projetoGCA\Evento::find($evento))
                                    @foreach ($evento->locaisretiradaevento as $local)
                                        @if (old('localretiradaevento') == $local->id)
                                            <option value="{{$local->id}}" selected>{{$local->localretirada()->withTrashed()->first()->nome}}</option>
                                        @else
                                            <option value="{{$local->id}}">{{$local->localretirada()->withTrashed()->first()->nome}}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <br>
                                <a href="{{URL::previous()}}" class="btn btn-danger">Voltar</a>
                                <button type="submit" class="btn btn-primary">
                                    Finalizar Pedido
                                </button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
