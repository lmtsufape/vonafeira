@extends('layouts.app')

@section('titulo','Gerenciar Grupo de Consumo')

@section('navbar')
    <a href="/home">Início</a> > <a href="/gruposConsumo">Grupos de Consumo</a> > Gerenciar Grupo: {{$grupoConsumo->name}}
@endsection

<!--/gerenciar/2-->

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Grupo de Consumo: <strong>{{$grupoConsumo->name}}</strong>

                  <a href="{{action('GrupoConsumoController@editar', $grupoConsumo->id)}}">
                    <img src="{{asset('images/edit.png')}}" style = "margin-left: 15px; margin-right: -10px " height="25" width="25" align = "right">
                  </a>
                </div>

                <div class="panel-body">
                    <div style="width: 100%; margin-left: 0%" class="row">
                        <div style="width: 50%; float: left" class="column col-md-8">
                            <strong>Descrição</strong>
                            @if($grupoConsumo->descricao == NULL)
                            <p>Não há descrição.</p>
                            @endif
                            <p>{{$grupoConsumo->descricao}}</p>
                        </div>
                        <div style="width: 50%; float: left" class="column col-md-8">
                            <strong>Localidade/Estado</strong>
                            <p>{{$grupoConsumo->localidade}}/{{$grupoConsumo->estado}}</p>
                            <strong>Dia de ocorrência</strong>
                            <p>{{$grupoConsumo->dia_semana}}</p>
                            <strong>Periodicidade</strong>
                            <p>{{$grupoConsumo->periodo}}</p>
                            <strong>Dia limite para pedidos </strong>
                            <p>{{($grupoConsumo->prazo_pedidos == 1 ? $grupoConsumo->prazo_pedidos.' dia antes do evento.': $grupoConsumo->prazo_pedidos.' dias antes do evento.')}}</p>
                        </div>
                    </div>
                    <hr>


                    <a href="{{action('EventoController@listar', $grupoConsumo->id)}}" class="btn btn-primary">Eventos</a>
                    <a href="{{action('ProdutorController@listar', $grupoConsumo->id)}}" class="btn btn-primary">Produtores</a>
                    <a href="{{action('ProdutoController@listar', $grupoConsumo->id)}}" class="btn btn-primary">Produtos</a>
                    <a href="/unidadesVenda/{{$grupoConsumo->id}}" class="btn btn-primary">Unidades de Venda</a>
                    <a href="{{action('ConsumidorController@listar', $grupoConsumo->id)}}" class="btn btn-primary">Consumidores</a>
                    <a href="/compartilhar/{{$grupoConsumo->id}}" class="btn btn-primary">Compartilhar</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
