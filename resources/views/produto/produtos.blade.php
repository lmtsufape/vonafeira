@extends('layouts.app')

@section('titulo','Listar Produtos')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    <a href="{{ route("grupoConsumo.listar") }}">Grupos de Consumo</a> >
    <a href="{{ route("grupoConsumo.gerenciar", ["id" => $grupoConsumo->id]) }}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> >
    Listar Produtos
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Produtos</div>
                @if(old('nome'))
                    <div class="alert alert-success">
                        <strong>Sucesso!</strong>
                        O produto {{old('nome')}} foi adicionado.
                    </div>
                @endif
                <div class="panel-body">
                @if(count($produtos) == 0)
                    <div class="alert alert-danger">
                            Não existem produtos cadastrados para este grupo de consumo.
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
                            <th colspan="2">Ações</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($produtos as $produto)
                          <tr>
                            @php($produtor = \projetoGCA\Produtor::where('id','=',$produto->produtor_id)->first())
                            <td data-title="Nome">{{ $produto->nome }}</td>
                            <td data-title="Produtor">{{ $produtor->nome}}</td>
                            <td data-title="Descrição">{{ $produto->descricao }}</td>
                            <td data-title="Preço">{{ 'R$ '.number_format($produto->preco, 2 )}}</td>
                            <td data-title="Unidade de Venda">{{ $produto->unidadeVenda->nome }}</td>
                            <td>
                              <a class="btn btn-success" href="{{ route("produto.editar", ["idProduto" => $produto->id]) }}">
                                Editar
                              </a>
                            </td>
                            <td>
                              <a class="btn btn-danger" onclick="return confirm('Confirmar remoção de {{ $produto->nome}}?')" href="{{ route("produto.remover", ["idProduto" => $produto->id]) }}">
                                Remover
                              </a>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
                </div>
                <div class="panel-footer">
                    <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
                    <a class="btn btn-success" href="{{ route("produto.novo", ["idGrupoConsumo" => $grupoConsumo->id]) }}">Novo</a>
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
