@extends('_mobile.layout.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Entrar em Grupo de Consumo</div>
        <div class="panel-body" style="text-align: left">
            <form class="form-horizontal" method="POST" action="{{ route("consumidor.cadastrar") }}">
                {{ csrf_field() }}

                <select id="grupoConsumo" class="form-control" name="grupoConsumo" required>
                    <option value="" selected disabled hidden>Selecione</option>
                        @foreach($gruposConsumo as $grupoConsumo)
                            <option value={{$grupoConsumo->id}}>{{$grupoConsumo->name}}</option>
                        @endforeach
                    </select>
                    <div class="col-md-6">
                      <div class="form-group">
                        <div style="margin-top: 3px">
                          <button type="submit" class="btn btn-success">
                              Entrar
                          </button>
                        </div>
                    </div>
                </div>

                <!-- Tabela, método post inviabiliza no momento
                <table class="table table-striped">
                    <tr>
                        <th>Grupo</th>
                        <th>Coordenador</th>
                    </tr>
                    @foreach($gruposConsumo as $grupo)
                    <div style="background-color:#000000">
                        <tr>
                            <td>
                                <strong>Nome: </strong>
                                {{$grupo->name}}
                                <br>
                                <strong>Coordenador: </strong>
                                {{$grupo->coordenador->name}}
                            </td>
                            <td>
                                <strong>Localidade: </strong>
                                {{$grupo->cidade}}/{{$grupo->estado}}
                                <br>
                                <a class="btn btn-success">Entrar</a>
                            </td>
                        </tr>
                        <tr>
                            
                        </tr>
                    </div>
                    @endforeach
                </table> -->
            </form>
        </div>
    </div>
@endsection