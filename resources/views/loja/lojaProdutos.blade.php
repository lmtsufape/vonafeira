@extends('layouts.app')

@section('navbar')
  <a href="{{ route("home") }}">Início</a> >
  <a href="{{ route("loja") }}">Loja</a> >
  Evento em: {{$grupoConsumo->name}}
@endsection

@section('titulo','Loja')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Produtos</div>
                <form class="form-horizontal" method="POST" action="{{ route("carrinho") }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="panel-body">
                        @if (\Session::has('fail'))
                        <br>
                            <div class="alert alert-danger">
                                <strong>Erro!</strong>
                                {!! \Session::get('fail') !!}
                            </div>
                        @endif
                        @if(count($produtos) == 0)
                          <div class="alert alert-danger">
                            Não existem produtos disponíveis no momento.
                          </div>
                        @else
                          <input id="evento_id" type="hidden" class="form-control" name="evento_id" value="{{ $evento->id }}" >
                          <input id="grupo_consumo_id" type="hidden" class="form-control" name="grupo_consumo_id" value="{{ $grupoConsumo->id }}" >

                          <input type="text" id="termo" onkeyup="buscar()" placeholder="Busca">

                          <div id="tabela" class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                  <tr>
                                      <th></th>
                                      <th>Nome</th>
                                      <th>Descrição</th>
                                      <th>Preço</th>
                                      <th>Quantidade</th>
                                      <th>Unidade</th>
                                      <th>Produtor</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach($produtos as $produto)
                                  <input id="item_id" type="hidden" class="form-control" name="item_id[{{$produto->id}}]" value="{{ $produto->id }}" >
                                  <tr>
                                      <td>
                                        <input type="checkbox" onchange="Enable(this)" nome="checkbox_{{$produto->id}}" value="old()" id="checkbox_{{$produto->id}}">
                                      </td>
                                      <td data-title="Nome">{{ $produto->nome }}</td>
                                      <td data-title="Descrição">{{ $produto->descricao }}</td>
                                      <td data-title="Preço">{{ 'R$ '.number_format($produto->preco,2)}}</td>
                                      @if(($produto->unidadeVenda->is_fracionado) == 1)
                                        <td data-title="Quantidade"><input disabled id="quantidade[{{$produto->id}}]" style="width: 6em" type="number" min="0" step="0.1" class="form-control" name="quantidade[{{$produto->id}}]" id="quantidade[{{$produto->id}}]" value="{{ old('quantidade') }}"></td>
                                      @else
                                        <td data-title="Quantidade"><input disabled id="quantidade[{{$produto->id}}]" style="width: 6em" type="number" min="0" step="1" class="form-control" name="quantidade[{{$produto->id}}]" id="quantidade[{{$produto->id}}]" value="{{ old('quantidade') }}"></td>
                                      @endif
                                      <td data-title="Unidade">{{ $produto->unidadeVenda->nome }}</td>
                                      @php($produtor = \projetoGCA\Produtor::find($produto->produtor_id))
                                      <td data-title="Produtor">{{$produtor->nome}}</td>
                                  </tr>
                                  @endforeach
                                <tbody>
                            </table>
                          <div id="tabela" class="table-responsive">

                    </div>
                    <div class="panel-footer">
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-13">
                                <a href="{{ route("loja") }}" class="btn btn-danger">Voltar</a>
                                <button type="submit" class="btn btn-primary">
                                    Adicionar ao Carrinho
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
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
        td = tr[i].getElementsByTagName("td")[1];
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

    Enable = function(checkbox)
    {

      var element_id = (checkbox.id).replace('checkbox_','');

      var input = document.getElementById(("quantidade[").concat(element_id,"]"));

      if(checkbox.checked == true){
          input.disabled = false;
      }else{
          input.disabled = true;
          input.value = "";
      }

      
    }
</script>

@endsection
