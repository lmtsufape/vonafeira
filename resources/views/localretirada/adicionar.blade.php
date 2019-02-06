@extends('layouts.app')

@section('titulo','Cadastrar Local de Retirada')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> > 
    <a href="{{ route("grupoConsumo.listar")}}">Grupos de Consumo</a> > 
    <a href="{{ route("grupoConsumo.gerenciar", ["id" => $grupoConsumo->id]) }}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> >
    <a href="{{ route('locaisretirada.listar',['grupoconsumo_id' => $grupoConsumo->id]) }}">Locais de Retirada</a> > Adicionar
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Novo Local de Retirada</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action=" {{ route('locaisretirada.criar') }} ">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('grupoConsumo') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <input id="grupoConsumo" type="hidden" class="form-control" name="grupoConsumo" value="{{$grupoConsumo->id}}">
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                            <label for="nome" class="col-md-4 control-label">Nome do Local</label>

                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control" name="nome" value="{{ old('nome') }}" autofocus>

                                @if ($errors->has('nome'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nome') }}</strong>
                                    </span>
                                @endif
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
@endsection
