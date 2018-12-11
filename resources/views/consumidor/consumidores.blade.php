@extends('layouts.app')

@section('navbar')
    <a href="/home">Painel</a> > <a href="/gruposConsumo">Grupos de Consumo</a> > <a href="/gerenciar/{{$grupoConsumo->id}}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> > Consumidores
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Consumidores</div>

                <div class="panel-body">
                @if(count($consumidores) == 0)
                    <div class="alert alert-danger">
                            Não existem Consumidores cadastrados.
                    </div>
                @else
                    <table class="table table-hover"> 
                        <tr>
                            <th>Cod</th>
                            <th>Usuário</th>
                            <th>Grupo de Consumo</th>
                            <th>Ações</th>
                        </tr>
                        @foreach ($consumidores as $consumidor)
                        <tr>
                            <td>{{ $consumidor->id }}</td>
                            <td>{{ $consumidor->usuario->name }}</td>
                            <td>{{ $consumidor->grupoConsumo->name}}</td> 
                        </tr>
                        @endforeach
                    </table>
                @endif
                </div>
                <div class="panel-footer">
                    <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection