@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/evento.compartilhar.css') }}" rel="stylesheet"/>
@stop

@section('titulo','Gerenciar Grupo de Consumo')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    <a href="{{ route("grupoConsumo.listar") }}">Grupos de Consumo</a> >
    <a href="{{ route("grupoConsumo.gerenciar", ["id" => $grupoConsumo->id]) }}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> >
    Compartilhar
@endsection

<!--/gerenciar/2-->

@section('content')

    <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Grupo de consumo: <strong>{{$grupoConsumo->name}}</strong></div>
                        <div class="panel-body">

                                @if($user_in == 1)

                                    Para compartilhar seu grupo de consumo com outras pessoas, {{$coordenador->name}},
                                    apenas envie o seguinte link para elas:<br>
                                    <div style="text-align: center">
                                        <input type="text" style="text-align: center" size="40" value="{{ route('compartilhar.get',$grupoConsumo->id) }}" readonly></input>
                                    </div>
                                    <br>

                                    <hr>

                                    <div style="text-align: center">

                                            <strong>Envie por e-mail</strong>
                                            <div class="panel-body">
                                                @if (\Session::has('success'))
                                                <br><div class="alert alert-success">
                                                    <strong>Sucesso!</strong>
                                                    {!! \Session::get('success') !!}
                                                </div>
                                                @elseif (\Session::has('fail'))
                                                <br><div class="alert alert-danger">
                                                    <strong>Falha!</strong>
                                                    {!! \Session::get('fail') !!}
                                                </div>
                                                @endif


                                                <form action="{{ route("compartilhar.post") }}" method="POST">
                                                {{csrf_field()}}
                                                <input type="text" name="grupoConsumoId" value="{{$grupoConsumo->id}}" hidden>
                                                <input type="email" name="email" value="{{old('email')}}">
                                                <button type="submit" class="btn btn-success">Enviar</button>
                                            </form>

                                        </div>
                                    </div>

                                @elseif($user_in == 2)

                                    Você já partipa do grupo de consumo do coordenador {{$coordenador->name}}.

                                @else

                                    <h4>O coordenador <strong>{{$coordenador->name}}</strong> está te convidadando
                                    a participar do grupo de consumo dele.</h4>
                                    <form class="form-horizontal" method="POST" action="{{ route("consumidor.cadastrar") }}">
                                        {{ csrf_field() }}
                                        <input name="grupoConsumo" value="{{$grupoConsumo->id}}" hidden>
                                        <button type="submit" class="btn btn-success">Entrar</button>
                                        <a  href="{{ route("home") }}" class="btn btn-danger">Início</a>
                                    </form>

                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
