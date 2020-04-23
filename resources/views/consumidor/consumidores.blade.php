@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/consumidor.consumidores.css') }}" rel="stylesheet"/>
@stop

@section('titulo','Consumidores')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    <a href="{{ route("grupoConsumo.listar") }}">Grupos de Consumo</a> >
    <a href="{{ route("grupoConsumo.gerenciar", ["id" => $grupoConsumo->id]) }}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> >
    Consumidores
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          @if (\Session::has('success'))
            <div style="text-align: center" class="alert alert-success">
                <strong>Sucesso!</strong>
                {!! \Session::get('success') !!}
            </div>
          @endif
            <div class="panel panel-default">
                <div class="panel-heading">Consumidores</div>
                <form class="form-horizontal" method="POST" action="{{ route('consumidor.escrever.email', ['grupoConsumoId' => $grupoConsumo]) }}">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">                  

                  <div class="panel-body">
                  @if(count($consumidores) == 0)
                      <div class="alert alert-danger">
                              Não existem Consumidores cadastrados.
                      </div>
                  @else
                  @if (\Session::has('fail'))
                      <br>
                      <div class="alert alert-danger">
                          <strong>Erro!</strong>
                          {!! \Session::get('fail') !!}
                      </div>
                  @endif
                    <div id="cabecalho">
                      <input type="text" id="termo" onkeyup="buscar()" placeholder="Busca">                     
                    </div></br>

                    <div id="tabela" class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>                              
                              <th><input type="checkbox"  onchange="marcar(this)" name="checkbox_all" value="old()" id="checkbox_all"></th>
                              <th width="80%">Usuário</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($consumidores as $consumidor)
                            @if($consumidor->id != $grupoConsumo->coordenador->id)
                              <tr>                             
                                  <td><input type="checkbox" class="checkbox" name="checkbox[{{$consumidor->id}}]" value="old()" id="checkbox_{{$consumidor->id}}"></td>
                                  <td data-title="Usuario">{{ $consumidor->name }}</td>
                              </tr>
                            @endif
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  @endif
                  </div>
                  <div class="panel-footer">
                      <a class="btn btn-danger" href="{{ route("grupoConsumo.gerenciar", ["id" => $grupoConsumo->id]) }}">Voltar</a>
                      <button id="email" class="btn btn-primary" type="submit">Enviar Email</button>
                  </div>
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

    function marcar(elemento) {
      checkboxes = document.getElementsByClassName('checkbox');
      console.log(checkboxes);
      for(var i=0, n=checkboxes.length;i<n;i++) {
        checkboxes[i].checked = elemento.checked;
    }
}
</script>

@endsection
