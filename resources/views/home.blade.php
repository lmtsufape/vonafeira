@extends('layouts.app')

@section('titulo','Início')

@section('navbar')
    Painel
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Painel</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                          {{ session('status') }}
                        </div>
                    @endif

                    <div class="panel-footer">
                        <div class="form-group">
                            <a href="/gruposConsumo" class="btn btn-primary " role="button" aria-pressed="true">Meus grupos de consumo</a>
                            <a href="/selecionarGrupo" class="btn btn-primary " role="button" aria-pressed="true">Entrar em grupo de consumo</a>
                                <a href="/loja" class="btn btn-primary" role="button" aria-pressed="true">Comprar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
