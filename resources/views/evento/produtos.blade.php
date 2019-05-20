@extends('layouts.app')

@section('titulo','Produtos do Evento')

@section('navbar')
  <a href="{{ route("home") }}">Início</a> >
  <a href="{{ route("grupoConsumo.listar") }}">Grupos de Consumo</a> >
  <a href="{{ route("grupoConsumo.gerenciar", ["id" => $grupoConsumo->id]) }}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> >
  <a href="{{ route("evento.listar", ["idGrupoConsumo" => $grupoConsumo->id]) }}">Listar Eventos</a> >
  Adicionar
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Produtos Participantes do Evento</div>

                <div class="panel-body">
                  @if(count($produtos) == 0)
                    <div class="alert alert-danger">
                      Não existem produtos cadastrados para este grupo de consumo.
                    </div>
                    <div class="panel-footer">
                      <button type="submit" disabled class="btn btn-primary">
                        Cadastrar
                      </button>
                    </div>
                  @else
                    <input type="text" id="termo" onkeyup="buscar()" placeholder="Busca">

                    <div id="tabela" class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                              <th>Nome</th>
                              <th>Produtor</th>
                              <th>Descrição</th>
                              <th>Preço</th>
                              <th>Unidade de Venda</th>
                              <th>Ativo</th>
                          </tr>
                        </thead>
                        <tbody>
                          <form class="form-horizontal" method="POST" action="{{ route("evento.produtos.desativar") }}">

                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input id="idGrupoConsumo" type="hidden" class="form-control" name="idGrupoConsumo" value="{{ $grupoConsumo->id }}" >

                          @foreach ($produtos as $produto)
                            <tr>
                              @php($produtor = \projetoGCA\Produtor::where('id','=',$produto->produtor_id)->first())
                              <td data-title="Nome">{{ $produto->nome }}</td>
                              <td data-title="Produtor">{{ $produtor->nome}}</td>
                              <td data-title="Descrição">{{ $produto->descricao }}</td>
                              <td data-title="Preço">{{ 'R$ '.number_format($produto->preco, 2 )}}</td>
                              <td data-title="Unidade de Venda">{{ $produto->unidadeVenda->nome }}</td>
                              <td>
                                <input class="form-check-input position-static" checked type="checkbox" value="{{$produto->id}}" id="checkbox{{$produto->id}}" name="checkbox[{{$produto->id}}]">
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                    <div class="panel-footer">
                      <button type="submit" class="btn btn-primary">
                        Cadastrar
                      </button>
                    </div>
                  @endif
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
