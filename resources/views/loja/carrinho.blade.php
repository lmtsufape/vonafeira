@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Finalizar Pedido</h1></div>
                <form class="form-horizontal" method="POST" action="{{action('PedidoController@finalizar')}}">   
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                    <input id="evento_id" type="hidden" class="form-control" name="evento_id" value="{{ $evento }}" >  

                <div class="panel-body">
                    <table class="table table-hover">  
                        <thead>
                            
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Unidade de Venda</th>
                            <th>Preço</th>
                            
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Total</th>
                                <th>{{$total}}</th>
                            </tr>
                        </tfoot>
                            @for ($i = 0; $i < count($quantidades); $i++)
                            <input id="produto_id" type="hidden" class="form-control" name="produto_id[{{$i}}]" value="{{ $produtos[$i]['id'] }}" >
                            <input id="quantidade[{{$i}}]" type="hidden" class="form-control" name="quantidade[{{$i}}]" value="{{ $quantidades[$i] }}" >
                            <tr>
                                <td>{{ $produtos[$i]['nome'] }}</td>
                                <td>{{ $quantidades[$i] }}</td>
                                <td>{{\projetoGCA\UnidadeVenda::find($produtos[$i]['unidadevenda_id'])->nome }}</td>
                                <td>{{ $produtos[$i]['preco']*$quantidades[$i] }}</td>
                            </tr>
                            @endfor
                    </table>
                </div>
                    <div class="panel-footer">
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-13">
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