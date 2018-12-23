@extends('layouts.app')

@section('titulo','Painel')

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
                    Usuário
                    {{ Auth::user()->name }}
                    Logado!<br>
                    <div class="panel-footer">
                        <div class="form-group">
                                <a href="/loja" class="btn btn-success btn-lg active" role="button" aria-pressed="true">Comprar</a>
                                <a href="/selecionarGrupo" class="btn btn-success btn-lg active" role="button" aria-pressed="true">Selecionar Grupo De Consumo</a>
                                <a href="/gruposConsumo" class="btn btn-success btn-lg active" role="button" aria-pressed="true">Meus Grupos de Consumo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
