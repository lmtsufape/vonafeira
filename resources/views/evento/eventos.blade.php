@extends('layouts.app')

@section('titulo','Lista de Eventos')

@section('navbar')
    <a href="/home">Painel</a> > <a href="/gruposConsumo">Grupos de Consumo</a> > <a href="/gerenciar/{{$grupoConsumo->id}}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> > Listar Eventos
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Eventos</div>
                    @if(old('data_evento'))
                        <div class="alert alert-success">
                            <strong>Sucesso!</strong>
                            O evento o foi adicionado.
                        </div>
                    @endif
                    @if(session('warning'))
                        <div class="alert alert-danger">
                            <strong>Aviso!</strong>
                            {{session('warning')}}
                        </div>
                    @endif
                <div class="panel-body">
                    @if(count($eventos) == 0)
                        <div class="alert alert-danger">
                                Não existem eventos cadastrados.
                        </div>
                    @else
                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <strong>Sucesso!</strong>
                            {!! \Session::get('success') !!}
                        </div>
                    @endif
                      <div class="table-responsive">
                        <table class="table table-hover">

                          <tr>
                              <th>Data do evento</th>
                              <th>Hora do evento</th>
                              <th>Data de início dos pedidos</th>
                              <th>Data de fim dos pedidos</th>
                              <th>Aberto</th>
                              <th>Local de retirada</th>
                              <th>Pedidos</th>
                              <th>Ações</th>

                          </tr>

                          @foreach ($eventos as $evento)
                          <tr>
                              <td>{{ \projetoGCA\Http\Controllers\UtilsController::dataFormato($evento->data_evento, 'd/m/Y') }}</td>
                              <td>{{ $evento->hora_evento }}</td>
                              <td>{{ \projetoGCA\Http\Controllers\UtilsController::dataFormato($evento->data_inicio_pedidos, 'd/m/Y') }}</td>
                              <td>{{ \projetoGCA\Http\Controllers\UtilsController::dataFormato($evento->data_fim_pedidos, 'd/m/Y') }}</td>

                              <td>
                                @if ($evento->estaAberto)
                                  Sim
                                @else
                                  Não
                                @endif
                              </td>
                              <td>{{$evento->local_retirada}}</td>
                              <td><a class="btn btn-primary" href="{{action('EventoController@pedidos', $evento->id)}}">Visualizar</a></td>
                              @if($evento->estaAberto)
                                  <td><a class="btn btn-danger" href="/evento/fechar/{{$evento->id}}">Fechar</a></td>
                              @else
                                  <td><button type="button" class="btn btn-danger" disabled>Fechado</button></td>
                              @endif

                          </tr>
                          @endforeach
                          </tbody>
                      </table>
                      </div>
                    @endif
                </div>
                <div class="panel-footer">
                    <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
                    <a class="btn btn-success" href="{{action('EventoController@novo', $grupoConsumo->id)}}">Novo</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
