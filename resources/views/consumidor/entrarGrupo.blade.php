@extends('layouts.app')

@section('titulo','Entrar em Grupo de Consumo')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    Buscar Grupos de Consumo
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Grupos de consumo</div>
                  <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route("grupoConsumo.buscar") }}">
                      {{ csrf_field() }}
                      <div class="input-field">
                        <div class="col-sm-10">
                          @if ($termo == null)
                            <input id="termo" type="text" class="form-control" name="termo" autofocus required placeholder="Nome, cidade, UF ou coordenador">
                          @else
                            <input id="termo" type="text" class="form-control" name="termo" autofocus value="{{$termo}}" required placeholder="Nome, cidade, UF ou coordenador">
                          @endif
                        </div>

                        <button type="submit" class="btn btn-primary">
                          Buscar
                        </button>
                      </div>
                    </form>
                    <br>
                    <div id="tabela" class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>Nome</th>
                            <th>Coordenador</th>
                            <th>Local</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($gruposConsumo as $grupoConsumo)
                            <?php
                              $user = \projetoGCA\User::find($grupoConsumo->coordenador_id);
                            ?>
                            <tr>
                              <td data-title="Nome">{{ $grupoConsumo->name }}</td>
                              <td data-title="Coordenador">{{ $user->name }}</td>
                              <td data-title="Local">{{ $grupoConsumo->cidade }} - {{ $grupoConsumo->estado }}</td>
                              <td>
                                <a class="btn btn-primary" href="{{ route("grupoConsumo.exibir", ["grupoConsumoId" => $grupoConsumo->id]) }}">
                                  Ver
                                </a>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>

@endsection
