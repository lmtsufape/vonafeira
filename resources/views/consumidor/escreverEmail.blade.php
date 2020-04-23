@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/consumidor.escreverEmail.css') }}" rel="stylesheet"/>
@stop

@section('titulo','Consumidores')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    <a href="{{ route("grupoConsumo.listar") }}">Grupos de Consumo</a> >
    <a href="{{ route("grupoConsumo.gerenciar", ["id" => $grupoConsumo->id]) }}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> >
    <a href="{{ route("consumidor.listar", ["id" => $grupoConsumo->id]) }}">Consumidores</a> >
    Enviar Email
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form class="form-horizontal" method="POST" action="{{ route('enviar.email') }}">           
                <div class="panel panel-default">
                    <div class="panel-heading">Enviar Email</div>
                
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                    <input type="hidden" name="grupo_consumo" value="{{ $grupoConsumo->id }}">
                    
                    
                    <div class="panel-body" id="panel-email">
                                            
                        <input class="form-control" type="text" name="assunto" id="assunto"  placeholder="Assunto"></br>

                        <textarea class="form-control" name="mensagem" id="mensagem" placeholder="Mensagem"></textarea>

                        <button type="submit" class="btn btn-primary btn-lg" id="enviarbtn">Enviar</button>
                        
                    </div>
                    <hr>
                    <h3>Destinatários</h3>         
                        
                        <div class="panel-body">
                            @if(count($destinatarios) == 0)
                                <div class="alert alert-danger">
                                        Não há destinatários selecionados.
                                </div>
                            @else                      
                                <div id="tabela" class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>                                        
                                                <th>Nome</th>
                                                <th>Email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($destinatarios as $destinatario)
                                                @if($destinatario->id != $grupoConsumo->coordenador->id)
                                                <tr>
                                                    <td data-title="Nome" name="destinatario[{{ $destinatario->id }}]">{{ $destinatario->name }}</td>
                                                    <td data-title="Email" name="destinatario[{{ $destinatario->id }}]">{{ $destinatario->email }}</td>
                                                    <input type="hidden" name="nomes[{{ $destinatario->id }}]" value="{{ $destinatario->name }}">
                                                    <input type="hidden" name="emails[{{ $destinatario->id }}]" value="{{ $destinatario->email }}">
                                                </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>

                        <div class="panel-footer">
                            <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
