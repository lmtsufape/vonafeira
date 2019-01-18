@extends('layouts.app')

@section('navbar')
    <a href="/home">Início</a> > Loja
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
                          <h3> Evento em: {{$grupoConsumo->name}} </h3>
                          @php($exibirMensagem = $exibirMensagem && false)
                        @endif

                        @foreach($eventos as $evento)
                          <div class="table-responsive">
                            <table class="table table-hover">
                              <tr>
                                  <th>Data do Evento</th>
                                  <th>Data Fim Pedidos</th>
                                  <th>Local de Retirada</th>

                              </tr>

                              <tr>
                                <td>{{ \projetoGCA\Http\Controllers\UtilsController::dataFormato($evento->data_evento, 'd/m/Y') }}</td></td>
                                <td>{{ \projetoGCA\Http\Controllers\UtilsController::dataFormato($evento->data_fim_pedidos, 'd/m/Y') }}</td></td>
                                <td>{{$evento->local_retirada}}</td>
                                <td><a class="btn btn-success" href="/loja/evento/{{$evento->id}}">Comprar</a></td>

                              </tr>

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
