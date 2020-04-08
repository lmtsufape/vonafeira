@extends('layouts.app')

@section('titulo','Listagem de Pedidos')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    <a href="{{ route("grupoConsumo.listar") }}">Grupos de Consumo</a> >
    <a href="{{ route("grupoConsumo.gerenciar", ["id" => $grupoConsumo->id]) }}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> >
    <a href="{{ route("evento.listar", ["idGrupoConsumo" => $grupoConsumo->id]) }}">Eventos</a> >
    <a href="{{ route("evento.pedidos", ["evento_id" => $evento->id]) }}"> Pedidos do Evento {{$evento->id}}</a> >
    Tipo do Pedido
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Tipo do Pedido</div>
                <div class="panel-body" >
                  <div id="tabela" class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                          <tr>
                              <th>Tipo</th>
                              <th>Local</th>
                          </tr>
                        </thead>
                        
                        <tbody>
                          
                            <?php
                              $tipo = "";
                              $local = "";
                              if($pedido->localretiradaevento_id != null){
                                $tipo = "Retirada";
                                $local = $pedido->localretiradaevento->localretirada()->withTrashed()->first()->nome;
                              }else if($pedido->endereco_consumidor_id != null){
                                $tipo = "Entrega";
                                $local = $pedido->endereco->rua . ", ";
                                  if($pedido->endereco->numero != null){
                                  $local .= "nº ". $pedido->endereco->numero . ", ";
                                  }
                                $local .= $pedido->endereco->bairro .", ". $pedido->endereco->cidade.", ".$pedido->endereco->uf ;
                              }else{
                                $tipo = "Indefinido";
                                $local = "-";
                              }
                            ?>
                            <tr>
                                <td data-title="Tipo">{{ $tipo }}</td>
                                <td data-title="Local">{{ $local }}</td>
                                
                            </tr>
                          
                        </tbody>
                        
                    </table>
                  </div>
                </div>
                <div class="panel-footer">
                    <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
