@extends('layouts.app')

@section('titulo','Início')

@section('navbar')
    Início
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Início</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                          {{ session('status') }}
                        </div>
                    @endif

                    <div class="panel-footer">
                        <div class="form-group" align="center">
                            <a href="{{ route("grupoConsumo.listar") }}" class="btn btn-primary " role="button" aria-pressed="true">Meus grupos de consumo</a>
                            <a href="{{ route("consumidor.grupo.entrar") }}" class="btn btn-primary " role="button" aria-pressed="true">Entrar em grupo de consumo</a>
                            <a href="{{ route("loja") }}" class="btn btn-primary" role="button" aria-pressed="true">Comprar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
