@extends('layouts.app')

@section('titulo','Consumidores')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    <a href="{{ route("grupoConsumo.listar") }}">Grupos de Consumo</a> >
    <a href="{{ route("grupoConsumo.gerenciar", ["id" => $grupoConsumo->id]) }}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> >
    Consumidores
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Enviar Email</div>
                <form class="form-horizontal" method="POST" action="{{ route('enviar.email') }}">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                  <div class="panel-body">
                  
                      <input class="form-control" type="text" id="assunto"  placeholder="Assunto"></br>

                      <textarea class="form-control" id="mensagem" placeholder="Mensagem"></textarea>
                      
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
