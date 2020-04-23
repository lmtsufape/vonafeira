@extends('layouts.app')

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
                      <input type="checkbox"  onchange="marcar(this)" name="checkbox_all" value="old()" id="checkbox_all">
                      <input type="text" id="termo" onkeyup="buscar()" placeholder="Busca">
                      <button type="submit" id="email-btn">Enviar Email</button>

                    <div id="tabela" class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                              <th></th>
                              <th>Usuário</th>
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
                      <a class="btn btn-danger" href="{{URL::previous()}}">Voltar</a>
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

    function marcar(elemento) {
      checkboxes = document.getElementsByClassName('checkbox');
      console.log(checkboxes);
      for(var i=0, n=checkboxes.length;i<n;i++) {
        checkboxes[i].checked = elemento.checked;
    }
}
</script>

@endsection
