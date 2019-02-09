@extends('layouts.app')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> > Loja
@endsection
@section('titulo','Loja')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Eventos
                </div>

                <div class="panel-body">
                    @php($exibirMensagem = true)
                    @if(count($gruposConsumo) == 0)
                      <div class="alert alert-danger">
                        Você não está cadastrado em nenhum Grupo de Consumo no momento.
                      </div>
                    @else
                      @foreach($gruposConsumo as $grupoConsumo)

                        <?php
                          $eventos = \projetoGCA\Http\Controllers\LojaController::buscarEventosDeGrupodeConsumo($grupoConsumo->id);
                        ?>

                        @if (count($eventos) != 0)
                          <h3> Eventos em: {{$grupoConsumo->name}} </h3>
                          @php($exibirMensagem = $exibirMensagem && false)
                        @endif

                        @foreach($eventos as $evento)
                          <div id="tabela" class="table-responsive">
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th>Data do Evento</th>
                                  <th>Data Fim Pedidos</th>
                                  <th>Local de Retirada</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td data-title="Data do Evento">{{ \projetoGCA\Http\Controllers\UtilsController::dataFormato($evento->data_evento, 'd/m/Y') }}</td></td>
                                  <td data-title="Data Fim Pedidos">{{ \projetoGCA\Http\Controllers\UtilsController::dataFormato($evento->data_fim_pedidos, 'd/m/Y') }}</td></td>
                                  <td data-title="Local de Retirada">
                                    @php($locais = \projetoGCA\LocalRetiradaEvento::where('evento_id','=',$evento->id)->get())
                                    @foreach($locais as $local)
                                        {{$local->localretirada()->withTrashed()->first()->nome}}
                                    @endforeach
                                  </td>

                                  <td data-title="">
                                    <a class="btn btn-success" href="{{ route("loja.evento", ["id" => $evento->id]) }}">
                                      Entrar
                                    </a>
                                  </td>

                                </tr>
                              </tbody>
                            </table>
                          </div>
                        @endforeach

                      @endforeach
                    @endif

                    @if($exibirMensagem)
                      <div class="alert alert-danger">
                        Não há eventos disponíveis no momento.
                      </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
