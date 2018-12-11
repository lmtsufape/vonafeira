@extends('layouts.app')

@section('navbar')
<a href="/home">Painel</a> > 
    <a href="/gruposConsumo">Grupos de Consumo</a> > <a href="/gerenciar/{{$grupoConsumo->id}}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> > Listar Unidades de Venda
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Unidades de Venda</div>

                <div class="panel-body">
                <table class="table table-hover">
                    
                    <tr>
                        <th>Cod</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Fracionado</th>
                        <th>Porção</th>
                        <th colspan="2">Ação</th>
                    </tr>
                    
                    @foreach ($listaUnidades as $unidadesVenda)
                    <tr>
                        <td>{{ $unidadesVenda->id }}</td>
                        <td>{{ $unidadesVenda->nome }}</td>
                        <td>{{ $unidadesVenda->descricao }}</td>
                        <td>{{ ($unidadesVenda->is_fracionado ? "Sim": "Não") }}</td>
                        <td>{{ ($unidadesVenda->is_porcao ? "Sim": "Não") }}</td> 
                        <td><a class="btn btn-success"href="{{ action('UnidadeVendaController@editar', $unidadesVenda->id) }}">Editar</a></td>
                        <td><a class="btn btn-danger"href="{{ action('UnidadeVendaController@remover',$unidadesVenda->id) }}">Remover</a></td>
                    </tr>

                    @endforeach
                </table>
                </div>
                <div class="panel-footer">
                    <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
                    <a class="btn btn-success" href="/adicionarUnidadeVenda/{{$grupoConsumo->id}}">Novo</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection