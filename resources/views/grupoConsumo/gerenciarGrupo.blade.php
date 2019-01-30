@extends('layouts.app')

@section('titulo','Gerenciar Grupo de Consumo')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    <a href="{{ route("grupoConsumo.listar") }}">Grupos de Consumo</a> >
    Gerenciar Grupo: {{$grupoConsumo->name}}
@endsection

<!--/gerenciar/2-->

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Grupo de Consumo: <strong>{{$grupoConsumo->name}}</strong>
                  <a href="{{ route("compartilhar.get", ["grupoConsumoId" => $grupoConsumo->id]) }}">
                    <img src="{{asset('images/share.png')}}" style = "margin-left: 15px; margin-right: -10px " height="25" width="25" align = "right">
                  </a>

                  <a href="{{ route("grupoConsumo.editar", ["id" => $grupoConsumo->id]) }}">
                    <img src="{{asset('images/edit.png')}}" style = "margin-left: 15px; margin-right: -10px " height="25" width="25" align = "right">
                  </a>


                </div>

                <div class="panel-body">
                    <div style="width: 100%; margin-left: 0%" class="row">
                        <div style="width: 50%; float: left" class="column col-md-8">
                            <strong>Coordenador</strong>
                            <p>{{$grupoConsumo->coordenador->name}}</p>
                            <strong>Descrição</strong>
                            @if($grupoConsumo->descricao == NULL)
                            <p>Não há descrição.</p>
                            @endif
                            <p>{{$grupoConsumo->descricao}}</p>
                        </div>
                        <div style="width: 50%; float: left" class="column col-md-8">
                            <strong>Localidade/Estado</strong>
                            <p>{{$grupoConsumo->cidade}}/{{$grupoConsumo->estado}}</p>
                            <strong>Dia de ocorrência</strong>
                            <p>{{$grupoConsumo->dia_semana}}</p>
                            <strong>Periodicidade</strong>
                            <p>{{$grupoConsumo->periodo}}</p>
                            <strong>Dia limite para pedidos </strong>
                            <p>{{($grupoConsumo->prazo_pedidos == 1 ? $grupoConsumo->prazo_pedidos.' dia antes do evento.': $grupoConsumo->prazo_pedidos.' dias antes do evento.')}}</p>
                        </div>
                    </div>
                    <hr>

                    <center>
                      <a href="{{ route("evento.listar", ["idGrupoConsumo" => $grupoConsumo->id]) }}" class="btn btn-primary">Eventos</a>
                      <a href="{{ route("produtor.listar", ["idGrupoConsumo" => $grupoConsumo->id]) }}" class="btn btn-primary">Produtores</a>
                      <a href="{{ route("produto.listar", ["idGrupoConsumo" => $grupoConsumo->id]) }}" class="btn btn-primary">Produtos</a>
                      <a href="{{ route("unidadeVenda.listar", ["grupoConsumoId" => $grupoConsumo->id]) }}" class="btn btn-primary">Unidades de Venda</a>
                      <a href="{{ route("consumidor.listar", ["idGrupoConsumo" => $grupoConsumo->id]) }}" class="btn btn-primary">Consumidores</a>
                      <a href="{{ route("locaisretirada.listar", ["grupoconsumo_id" => $grupoConsumo->id]) }}" class="btn btn-primary">Locais de Retirada</a>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
