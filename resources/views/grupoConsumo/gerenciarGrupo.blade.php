@extends('layouts.app')

@section('navbar')
    <a href="/home">Painel</a> > <a href="/gruposConsumo">Grupos de Consumo</a> > Gerenciar Grupo: {{$grupoConsumo->name}}
@endsection

<!--/gerenciar/2-->

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>{{$grupoConsumo->name}}</h1></div>

                <div class="panel-body">
                <h3>Descrição</h3>
                </br>
                <p>{{$grupoConsumo->descricao}}</p>
                </br>
                <h3>Dia de ocorrência</h3>
                </br>
                <p>{{$grupoConsumo->dia_semana}}</p>
                </br>
                <h3>Periodicidade</h3>
                </br>
                <p>{{$grupoConsumo->periodo}}</p>
                </br>
                <h3>Dia limite para pedidos </h3>
                </br>
                <p>{{($grupoConsumo->prazo_pedidos == 1 ? $grupoConsumo->prazo_pedidos.' dia antes do evento.': $grupoConsumo->prazo_pedidos.' dias antes do evento.')}}</p>
                </br>
                    <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
                    <a href="{{action('GrupoConsumoController@editar', $grupoConsumo->id)}}" class="btn btn-primary">Editar Grupo</a>
                    <a href="{{action('ProdutoController@listar', $grupoConsumo->id)}}" class="btn btn-primary">Produtos</a>
                    <a href="/unidadesVenda/{{$grupoConsumo->id}}" class="btn btn-primary">Unidades de Venda</a>
                    <a href="{{action('EventoController@listar', $grupoConsumo->id)}}" class="btn btn-primary">Eventos</a>
                    <a href="{{action('ConsumidorController@listar', $grupoConsumo->id)}}" class="btn btn-primary">Consumidores</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
