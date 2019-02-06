@extends('layouts.app')

@section('titulo','Lista de Produtores')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> > 
    <a href="{{ route("grupoConsumo.listar")}}">Grupos de Consumo</a> > 
    <a href="{{ route("grupoConsumo.gerenciar", ["id" => $grupoConsumo->id]) }}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> >
    Listar Locais de Retirada
@endsection

@section('content')
<h1><p id="teste"></p></h1>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Locais de Retirada</div>
                <div class="panel-body">
                @if(count($locaisRetirada) == 0)
                    <div class="alert alert-danger">
                            Não existem locais cadastrados neste grupo de consumo.
                    </div>
                @else
                    <input type="text" id="termo" onkeyup="buscar()" placeholder="Busca">

                  <div class="table-responsive">
                    <table id="tabela" class="table table-hover">
                        <tr>
                            <th>Nome</th>
                            <th colspan="2">Ações</th>
                        </tr>

                        @foreach ($locaisRetirada as $local)
                        <tr>
                            <td>{{ $local->nome}}</td>
                            <td>
                              <a class="btn btn-warning" href="{{ route('locaisretirada.editar',[$grupoConsumo->id,$local->id]) }}">Editar</a>
                            </td>
                            <td>
                              <a class="btn btn-danger" href="{{ route('locaisretirada.remover',[$grupoConsumo->id,$local->id]) }}" onclick="return confirm('Remover este local não afetará Os eventos atuais. Confirmar remoção de {{ $local->nome}}?')">Remover</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                  </div>
                @endif
                </div>
                <div class="panel-footer">
                    <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
                    <a class="btn btn-success" href="{{ route('locaisretirada.adicionar', ['grupoconsumo_id' => $grupoConsumo->id]) }}">Novo</a>
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
