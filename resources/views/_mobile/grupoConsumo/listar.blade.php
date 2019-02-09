@extends('_mobile.layout.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Meus Grupos de Consumo</div>
        <div class="panel-body" style="text-align: center">
            @if(count($gruposConsumo) == 0 and count($gruposConsumoParticipante) == 0)
                <div class="alert alert-danger">
                        Não existem grupos de consumo cadastrados.
                </div>
            @else
                <hr>
                @foreach($gruposConsumo as $grupo)
                    <div style="text-align: left" class="container">
                        <table>
                            <tr>
                                <th><strong>Grupo:</strong> {{$grupo->name}}
                            </tr>
                            <tr>
                                <td><strong>Coordenador: </strong>{{$grupo->coordenador->name}}</td>
                            </tr>
                            <tr>
                                <td><strong>Localização: </strong>{{$grupo->cidade}}/{{$grupo->estado}}</td>
                            </tr>
                            <tr>
                                <td><strong>Periodicidade: </strong>{{$grupo->periodo}} ({{$grupo->dia_semana}})</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Pedidos até: </strong>{{$grupo->prazo_pedidos}} dias antes
                                </td>
                            </tr>
                        </table>
                    </div>
                    <hr>
                @endforeach
                @foreach($gruposConsumoParticipante as $grupo)
                    @if($grupo->coordenador_id != Auth::user()->id)
                        <div style="text-align: left" class="container">
                            <table>
                                <tr>
                                    <th><strong>Grupo:</strong> {{$grupo->name}}
                                </tr>
                                <tr>
                                    <td><strong>Coordenador: </strong>{{$grupo->coordenador->name}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Localização: </strong>{{$grupo->cidade}}/{{$grupo->estado}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Periodicidade: </strong>{{$grupo->periodo}} ({{$grupo->dia_semana}})</td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Pedidos até: </strong>{{$grupo->prazo_pedidos}} dias antes
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <hr>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
@endsection