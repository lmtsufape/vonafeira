@extends('layouts.app')

@section('titulo','Lista de Produtores')

@section('navbar')
    <a href="/home">Início</a> > <a href="/gruposConsumo">Grupos de Consumo</a> > <a href="/gerenciar/{{$grupoConsumo->id}}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> > Listar Produtores
@endsection

@section('content')
<h1><p id="teste"></p></h1>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Produtores</div>
                @if(old('nome'))
                    <div class="alert alert-success">
                        <strong>Sucesso!</strong>
                        O produtor {{old('nome')}} foi adicionado.
                    </div>
                @endif
                <div class="panel-body">
                @if(count($produtores) == 0)
                    <div class="alert alert-danger">
                            Não existem produtores cadastrados neste grupo de consumo.
                    </div>
                @else
                    <input type="text" id="termo" onkeyup="buscar()" placeholder="Busca">

                  <div class="table-responsive">
                    <table id="tabela" class="table table-hover">
                        <tr>
                            <th>Nome do Produtor</th>
                            <th>Endereco</th>
                            <th>Telefone</th>
                            <th colspan="2">Ações</th>
                        </tr>

                        @foreach ($produtores as $produtor)
                        <tr>
                            <td>{{ $produtor->nome}}</td>
                            <td>{{ $produtor->endereco}}</td>
                            <td>{{ $produtor->telefone}}</td>
                            <td><a class="btn btn-success" href="{{ action('ProdutorController@editar', $produtor->id) }}">Editar</a></td>
                            <td>
                              <a class="btn btn-danger" onclick="return confirm('Remover {{$produtor->nome}} causará remoção de todos seus produtos. Continuar?')" href="{{ action('ProdutorController@remover',$produtor->id) }}">
                                Remover
                              </a>
                            </td>
                          </td>
                        </tr>
                        @endforeach
                    </table>
                  </div>
                @endif
                </div>
                <div class="panel-footer">
                    <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
                    <a class="btn btn-success" href="{{action('ProdutorController@novo', $grupoConsumo->id)}}">Novo</a>
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
