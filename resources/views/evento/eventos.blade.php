@extends('layouts.app')

@section('titulo','Lista de Eventos')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    <a href="{{ route("grupoConsumo.listar") }}">Grupos de Consumo</a> >
    <a href="{{ route("grupoConsumo.gerenciar", ["id" => $grupoConsumo->id]) }}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> >
    Listar Eventos
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Eventos</div>
                    @if(old('data_evento'))
                    <br>
                        <div class="alert alert-success">
                            <strong>Sucesso!</strong>
                            O evento o foi adicionado.
                        </div>
                    @endif
                    <br>
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
                    <br>
                        <div class="alert alert-success">
                            <strong>Sucesso!</strong>
                            {!! \Session::get('success') !!}
                        </div>
                    @endif
                      <div id="tabela" class="table-responsive">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                                <th>Data do evento</th>
                                <th>Hora do evento</th>
                                <th>Data de início dos pedidos</th>
                                <th>Data de fim dos pedidos</th>
                                <th>Aberto</th>
                                <th>Locais de retirada</th>
                                <th>Pedidos</th>
                                <th>Ações</th>

                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($eventos as $evento)
                              <tr>
                                <td data-title="Data do evento">{{ \projetoGCA\Http\Controllers\UtilsController::dataFormato($evento->data_evento, 'd/m/Y') }}</td>
                                <td data-title="Hora do evento">{{ $evento->hora_evento }}</td>
                                <td data-title="Data de início dos pedidos">{{ \projetoGCA\Http\Controllers\UtilsController::dataFormato($evento->data_inicio_pedidos, 'd/m/Y') }}</td>
                                <td data-title="Data de fim dos pedidos">{{ \projetoGCA\Http\Controllers\UtilsController::dataFormato($evento->data_fim_pedidos, 'd/m/Y') }}</td>

                                <td data-title="Aberto">
                                  @if ($evento->estaAberto)
                                    Sim
                                  @else
                                    Não
                                  @endif
                                </td>
                                <td data-title="Locais de Retirada">
                                  @php($locais = \projetoGCA\LocalRetiradaEvento::where('evento_id','=',$evento->id)->get())
                                  @foreach($locais as $local)
                                      {{$local->localretirada()->withTrashed()->first()->nome}}
                                  @endforeach
                                </td>
                                <td>
                                  <a class="btn btn-primary" href="{{ route("evento.pedidos", ["evento_id" => $evento->id]) }}">
                                    Visualizar
                                  </a>
                                </td>
                                @if($evento->estaAberto)
                                  <td>
                                    <a class="btn btn-danger" onclick="return confirm('Uma vez fechado um evento não pode ser reaberto. Confirmar fechamento do evento?')" href="{{ route("evento.fechar", ["eventoId" => $evento->id]) }}">
                                      Fechar
                                    </a>
                                  </td>
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

                    @if(is_null($ultimoEvento))
                      <a class="btn btn-success" href="{{ route("evento.novo", ["idGrupoConsumo" => $grupoConsumo->id]) }}">Novo</a>
                    @else
                      <a class="btn btn-success" disabled>Novo</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
