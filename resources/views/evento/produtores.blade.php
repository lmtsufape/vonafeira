@extends('layouts.app')

@section('titulo','Produtores do Evento')

@section('navbar')
  <a href="{{ route("home") }}">Início</a> >
  <a href="{{ route("grupoConsumo.listar") }}">Grupos de Consumo</a> >
  <a href="{{ route("grupoConsumo.gerenciar", ["id" => $grupoConsumo->id]) }}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> >
  <a href="{{ route("evento.listar", ["idGrupoConsumo" => $grupoConsumo->id]) }}">Listar Eventos</a> >
  Adicionar
@endsection

@section('content')
<h1><p id="teste"></p></h1>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Produtores Participantes do Evento</div>

                <div class="panel-body">
                  @if(count($produtores) == 0)
                    <div class="alert alert-danger">
                      Não existem produtores cadastrados neste grupo de consumo.
                    </div>
                  @else
                    <input type="text" id="termo" onkeyup="buscar()" placeholder="Busca">

                    <div id="tabela" class="table-responsive">
                      <table id="tabela" class="table table-hover">
                        <thead>
                          <tr>
                              <th>Nome do Produtor</th>
                              <th>Endereço</th>
                              <th>Telefone</th>
                              <th>Ativo</th>
                          </tr>
                        </thead>
                        <tbody>
                          <form class="form-horizontal" method="POST" action="{{ route("evento.produtores.desativar") }}">

                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input id="idGrupoConsumo" type="hidden" class="form-control" name="idGrupoConsumo" value="{{ $grupoConsumo->id }}" >

                          @foreach ($produtores as $produtor)
                            <tr>
                              <td data-title="Nome do Produtor">{{ $produtor->nome}}</td>
                              <td data-title="Endereço">{{ $produtor->endereco}}</td>
                              <td data-title="Telefone">{{ $produtor->telefone}}</td>
                              <td>
                                <input class="form-check-input position-static" checked type="checkbox" value="{{$produtor->id}}" id="checkbox{{$produtor->id}}" name="checkbox[{{$produtor->id}}]">
                              </td>
                            </tr>
                          @endforeach

                        </tbody>
                      </table>
                    </div>
                  @endif
                </div>
                <div class="panel-footer">
                  <button type="submit" class="btn btn-primary">
                    Cadastrar
                  </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function oi(){
    alert("Oi");
    }
</script>

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
