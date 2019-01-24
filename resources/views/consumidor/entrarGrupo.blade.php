@extends('layouts.app')

@section('titulo','Entrar em Grupo de Consumo')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    Entrar em Grupo de Consumo
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Grupos de consumo</div>
                  <div class="panel-body">
                      <form class="form-horizontal" method="POST" action="{{ route("consumidor.cadastrar") }}">
                          {{ csrf_field() }}
                          <div style="margin-left: 3px">
                            <strong>Selecione o grupo que queira fazer parte:</strong>
                          </div>
                          <div class="form-group{{ $errors->has('grupoConsumo') ? ' has-error' : '' }}">
                              <div class="col-md-6">
                                  <select id="grupoConsumo" class="form-control" name="grupoConsumo">
                                      <option value="" selected disabled hidden>Selecione</option>
                                      @foreach($gruposConsumo as $grupoConsumo)
                                          <option value={{$grupoConsumo->id}}>{{$grupoConsumo->name}}</option>
                                      @endforeach
                                  </select>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <div style="margin-top: 3px">
                                        <button type="submit" class="btn btn-success">
                                            Entrar
                                        </button>
                                      </div>
                                  </div>
                                  </div>
                              </div>
                          </div>
                      </form>
                  </div>
            </div>
        </div>
    </div>
</div>

<!-- Script do Select2 -->
<script src="{{ asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript">
    $( "#grupoConsumo" ).select2({
        theme: "bootstrap",
        placeholder: "Selecione o grupo"
    });
</script>
<!-- Script do Select2 -->

@endsection
