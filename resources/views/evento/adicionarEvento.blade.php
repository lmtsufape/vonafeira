@extends('layouts.app')

@section('titulo','Adicionar Evento')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    <a href="{{ route("grupoConsumo.listar") }}">Grupos de Consumo</a> >
    <a href="{{ route("grupoConsumo.gerenciar", ["id" => $grupoConsumo->id]) }}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> >
    <a href="{{ route("evento.listar", ["idGrupoConsumo" => $grupoConsumo->id]) }}">Listar Eventos</a> >
    Adicionar
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Novo Evento</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route("evento.cadastrar") }}">
                        {{ csrf_field() }}
                        <input type="hidden" class="form-control" name="id_grupo_consumo" value="{{ $grupoConsumo->id }}">

                        <div class="form-group{{ $errors->has('data_evento') ? ' has-error' : '' }}">
                            <label for="data_evento" class="col-md-4 control-label">Data do Evento</label>
                            <div class="col-md-6">

                                <input id="data_evento" type=date class="form-control" name="data_evento" value="{{ old('data_evento') }}">

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
                                <input id="hora_evento" type="time" class="form-control" name="hora_evento" value="{{ old('hora_evento') }}">
                                @if ($errors->has('hora_evento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('hora_evento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('locais') ? ' has-error' : '' }}">
                        <div class="form-group{{ $errors->has('input_outro') ? ' has-error' : '' }}">
                            <label for="locais" class="col-md-4 control-label">Locais</label>
                            <div class="col-md-6">
                                @if(old('locais',null) != NULL)
                                    @foreach($locaisretirada as $local)
                                        @if(in_array($local->id,old('locais')))
                                            <input type="checkbox" checked name="locais[{{ $local->id }}]" value="{{ $local->id }}">{{ $local->nome }} <br>
                                        @else
                                            <input type="checkbox" name="locais[{{ $local->id }}]" value="{{ $local->id }}">{{ $local->nome }} <br>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach($locaisretirada as $local)
                                        <input type="checkbox" name="locais[{{ $local->id }}]" value="{{ $local->id }}">{{ $local->nome }} <br>
                                    @endforeach
                                @endif
                                <input type="checkbox" name="checkbox_outro" onchange="Enable(this)">Outro<br>
                                <input id="input" name="input_outro" type="text" style="display: none">
                                
                                @if ($errors->has('input_outro'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('input_outro') }}</strong>
                                    </span>
                                @endif
                                @if ($errors->has('locais'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('locais') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
                                <button type="submit" class="btn btn-success">
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

<script type="text/javascript">
    Enable = function(checkbox){
        var input = document.getElementById('input')

        if(checkbox.checked == true){
            input.style.display = 'block';
        }else{
            input.style.display = 'none';
        }
    }
</script>

@endsection
