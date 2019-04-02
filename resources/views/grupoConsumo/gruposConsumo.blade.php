@extends('layouts.app')

@section('titulo','Meus Grupos de Consumo')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    Grupos de Consumo
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Grupos de Consumo</div>
                @if(old('name'))
                <br>
                    <div class="alert alert-success">
                        <strong>Sucesso!</strong>
                        O grupo foi adicionado.
                    </div>
                @endif
                @if (\Session::has('success'))
                <br>
                    <div class="alert alert-success">
                        <strong>Sucesso!</strong>
                        {!! \Session::get('success') !!}
                    </div>
                @endif
                <div class="panel-body">
                    @if(count($gruposConsumo) == 0 and count($gruposConsumoParticipante) == 0)
                    <div class="alert alert-danger">
                            Não existem grupos de consumo cadastrados.
                    </div>
                    @else
                    <input type="text" id="termo" onkeyup="buscar()" placeholder="Busca">

                      <div id="tabela" class="table-responsive">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Coordenador</th>
                                <th>Local</th>
                                <th colspan="2">Ações</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($gruposConsumo as $grupoConsumo)
                              <tr>
                                  <td data-title="Nome">{{ $grupoConsumo->name }}</td>
                                  <td data-title="Coordenador">{{ $grupoConsumo->coordenador->name }}</td>
                                  <td data-title="Local">{{ $grupoConsumo->cidade }} - {{ $grupoConsumo->estado }}</td>
                                  <td>
                                    <a class="btn btn-primary" style="width:103px"href="{{ route("grupoConsumo.gerenciar", ["id" => $grupoConsumo->id]) }}">
                                      Gerenciar
                                    </a>
                                  </td>
                                  <td></td>
                              </tr>
                            @endforeach

                            @foreach ($gruposConsumoParticipante as $grupoConsumo)
                              @if($grupoConsumo->coordenador_id != Auth::user()->id)
                                <tr>
                                    <td data-title="Nome">{{ $grupoConsumo->name }}</td>
                                    <td data-title="Coordenador">{{ $grupoConsumo->coordenador->name }}</td>
                                    <td data-title="Local">{{ $grupoConsumo->cidade }} - {{ $grupoConsumo->estado }}</td>
                                    <td>
                                      <a class="btn btn-success" href="{{ route("grupoConsumo.exibir", ["grupoConsumoId" => $grupoConsumo->id]) }}">
                                        Ver
                                      </a>
                                      <a class="btn btn-danger" onclick="return confirm('Você tem certeza que deseja sair do grupo de consumo {{$grupoConsumo->name}}?')" href="{{ route("grupoConsumo.sair", ["grupoConsumoId" => $grupoConsumo->id]) }}">
                                        Sair
                                      </a>
                                    </td>
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

                    <a class="btn btn-success" href="{{ route("grupoConsumo.novo") }}">Novo</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function buscar() {

      // Declare variables
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("termo");
      filter = input.value.toUpperCase();
      table = document.getElementById("tabela");
      tr = table.getElementsByTagName("tr");

      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
</script>

@endsection
