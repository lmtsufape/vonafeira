@extends('layouts.app')

@section('titulo','Gerenciar Grupo de Consumo')

@section('navbar')
    <a href="/home">Painel</a> > Entrar em Grupo: {{$grupoConsumo->name}}
@endsection

<!--/gerenciar/2-->

@section('content')

    <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="panel-heading"><h1>Grupo de Consumo {{$grupoConsumo->name}}</h1></div>
                            <div class="panel-body">

                                @if($user_in == 1)

                                    Para compartilhar seu grupo de consumo com outras pessoas, {{$coordenador->name}},
                                    apenas envie o seguinte link para elas:<br>
                                    <div style="text-align: center">
                                        <input type="text" style="text-align: center" size="40" value="{{$app->make('url')->to('/compartilhar/')}}/{{$grupoConsumo->id}}" readonly></input>
                                    </div>
                                    
                                @elseif($user_in == 2)

                                    Você já partipa do grupo de consumo do coordenador {{$coordenador->name}}.

                                @else

                                    <h4>O coordenador <strong>{{$coordenador->name}}</strong> está te convidadando 
                                    a participar do grupo de consumo dele.</h4>
                                    <form class="form-horizontal" method="POST" action="{{action('ConsumidorController@cadastrar')}}">
                                        {{ csrf_field() }}
                                        <input name="grupoConsumo" value="{{$grupoConsumo->id}}" hidden></input>
                                        <button type="submit" class="btn btn-success">Entrar</button>
                                        <a href="/" class="btn btn-danger">Início</a>
                                    </form>

                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection