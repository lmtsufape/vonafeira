@extends('layouts.app')

@section('titulo','Cadastrar Grupo de Consumo')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    <a href="{{ route("grupoConsumo.listar") }}">Grupos de Consumo</a> >
    Adicionar Grupo de Consumo
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Novo Grupo de Consumo</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route("grupoConsumo.cadastrar") }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{old('name')}}" autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                            <label for="descricao" class="col-md-4 control-label">Descrição</label>

                            <div class="col-md-6">
                                <input id="descricao" type="text" class="form-control" name="descricao" value="{{ old('descricao') }}">

                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('estado') ? ' has-error' : '' }}">
                            <label for="estado" class="col-md-4 control-label">Estado</label>

                            <div class="col-md-6">
                                <select id="estado" class="form-control" name="estado" value="{{ old('estado') }}" autofocus>

                                    @if (old('estado') == null)
                                        <option value="" selected disabled hidden>Selecionar</option>
                                    @endif

                                    @foreach($estados as $estado)
                                        @if(old('estado') == $estado)
                                            <option value={{$estado}} selected>{{$estado}}</option>
                                        @else
                                            <option value={{$estado}}>{{$estado}}</option>
                                        @endif
                                    @endforeach

                                </select>
                                @if ($errors->has('estado'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('estado') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('localidade') ? ' has-error' : '' }}">
                            <label for="localidade" class="col-md-4 control-label">Cidade</label>

                            <div class="col-md-6">
                                <input id="localidade" type="text" class="form-control" name="localidade" value="{{ old('localidade') }}">

                                @if ($errors->has('localidade'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('localidade') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('periodo') ? ' has-error' : '' }}">
                            <label for="periodo" class="col-md-4 control-label">Período</label>

                            <div class="col-md-6">
                            <select id="periodo" class="form-control" name="periodo" autofocus>
                                    @if (old('periodo') == NULL)
                                        <option value="" selected disabled hidden>Selecionar</option>
                                    @endif

                                    @foreach($periodos as $periodo)
                                        @if(old('periodo') == $periodo)
                                            <option value={{$periodo}} selected>{{$periodo}}</option>
                                        @else
                                            <option value={{$periodo}}>{{$periodo}}</option>
                                        @endif
                                    @endforeach

                                </select>
                                @if ($errors->has('periodo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('periodo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('dia_semana') ? ' has-error' : '' }}">
                            <label for="dia_semana" class="col-md-4 control-label">Dia do Evento</label>

                            <div class="col-md-6">
                                <select id="dia_semana" class="form-control" name="dia_semana" value="{{ old('dia_semana') }}" autofocus>
                                    @if (old('dia_semana') == NULL)
                                        <option value="" selected disabled hidden>Selecionar</option>
                                    @endif

                                    @foreach($dias as $dia)
                                        @if(old('dia_semana') == $dia)
                                            <option value={{$dia}} selected>{{$dia}}</option>
                                        @else
                                            <option value={{$dia}}>{{$dia}}</option>
                                        @endif
                                    @endforeach

                                </select>
                                @if ($errors->has('dia_semana'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dia_semana') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('dia_semana') ? ' has-error' : '' }}">
                            <label for="prazo_pedidos" class="col-md-4 control-label">Prazo Limite para Pedidos</label>

                            <div class="col-md-6">
                                <select id="prazo_pedidos" class="form-control" name="prazo_pedidos" value="{{ old('prazo_pedidos') }}" autofocus>
                                    @if (old('prazo_pedidos') == NULL)
                                        <option value="" selected disabled hidden>Selecionar</option>
                                    @endif

                                    @foreach($prazos_pedido as $prazo)
                                        @if(old('dia_semana') == $prazo)
                                            <option value={{$prazo}} selected>{{$prazo}} dia(s) antes</option>
                                        @else
                                            <option value={{$prazo}}>{{$prazo}} dia(s) antes</option>
                                        @endif
                                    @endforeach

                                </select>
                                @if ($errors->has('prazo_pedidos'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('prazo_pedidos') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a class="btn btn-danger" href="{{route('grupoConsumo.listar')}}">Voltar</a>
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

<script src="{{ asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript">
    $( "#estado" ).select2({
        theme: "bootstrap",
        placeholder: "Selecione o estado"
    });
</script>

@endsection
