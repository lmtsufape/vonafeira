@extends('layouts.app')

@section('navbar')
    <a href="/home">Painel</a> > <a href="/gruposConsumo">Grupos de Consumo</a> > <a href="/gerenciar/{{$grupoConsumo->id}}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> > Listar Eventos
@endsection



@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Novo Evento</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{action('EventoController@cadastrar')}}">
                        {{ csrf_field() }}
                        <input type="hidden" class="form-control" name="id_grupo_consumo" value="{{ $grupoConsumo->id }}">


                        <div class="form-group{{ $errors->has('data_evento') ? ' has-error' : '' }}">
                            <label for="data_evento" class="col-md-4 control-label">Data do Evento</label>
                            <div class="col-md-6">
                                <input id="data_evento" type=date class="form-control" name="data_evento" value="{{ old('data_evento') }}" required autofocus>
                                @if ($errors->has('data_evento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('data_evento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('hora_evento') ? ' has-error' : '' }}">
                            <label for="hora_evento" class="col-md-4 control-label">Horário</label>
                            <div class="col-md-6">
                                <input id="hora_evento" type="time" class="form-control" name="hora_evento" value="{{ old('hora_evento') }}" required autofocus>
                                @if ($errors->has('hora_evento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('hora_evento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
                                <button type="submit" class="btn btn-primary">
                                    Cadastrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
