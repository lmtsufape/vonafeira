@extends('layouts.app')

@section('titulo','Ver Grupo de Consumo')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    <a href="{{ route("consumidor.grupo.entrar") }}">Buscar Grupos de Consumo</a> >
    Informações do Grupo: {{$grupoConsumo->name}}
@endsection

<!--/gerenciar/2-->

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Grupo de Consumo: <strong>{{$grupoConsumo->name}}</strong>
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

                    <div class="panel-footer">
                        <a class="btn btn-danger" href="{{ route("consumidor.grupo.entrar") }}">Voltar</a>
                        <a class="btn btn-success" href="{{ route('consumidor.cadastrar', ['grupoConsumoid' => $grupoConsumo->id]) }}">Entrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
