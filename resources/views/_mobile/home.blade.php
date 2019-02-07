@extends('_mobile.layout.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Início</div>
        <div class="panel-body" style="text-align: center">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="form-group" align="center">
                <a style="margin-bottom:2px;" href="{{ route("grupoConsumo.listar") }}" class="btn btn-primary " role="button" aria-pressed="true">Meus grupos de consumo</a>
                <a href="{{ route("consumidor.grupo.entrar") }}" class="btn btn-primary " role="button" aria-pressed="true">Entrar em grupo de consumo</a>
            </div>
        </div>
    </div>
@endsection