@extends('layouts.app')

@section('navbar')
  <a href="{{ route("home") }}">Início</a> >
  <a href="{{ route("loja") }}">Loja</a> >
  <a href="{{ route("loja.evento", ["id" => $evento]) }}">Evento em: {{$grupoConsumo->name}}</a> >
  Carrinho
@endsection

@section('titulo','Carrinho')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Finalizar Pedido</strong></div>
                <form class="form-horizontal" method="POST" action="{{ route("pedido.finalizar") }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input id="evento_id" type="hidden" class="form-control" name="evento_id" value="{{ $evento }}" >
                    <input id="grupo_id" type="hidden" class="form-control" name="grupo_id" value="{{ $grupoConsumo->id }}" >
                <div class="panel-body">
                  <div id="tabela" class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <th>Produto</th>
                            <th>Descrição</th>
                            <th>Quantidade</th>
                            <th>Unidade de Venda</th>
                            <th>Preço</th>
                            <th>Produtor</th>
                        </thead>
                        <tbody>
                          @for ($i = 0; $i < count($quantidades); $i++)
                            <input id="produto_id" type="hidden" class="form-control" name="produto_id[{{$i}}]" value="{{ $produtos[$i]['id'] }}" >
                            <input id="quantidade[{{$i}}]" type="hidden" class="form-control" name="quantidade[{{$i}}]" value="{{ $quantidades[$i] }}" >
                            <tr>
                              <td data-title="Produto">{{ $produtos[$i]['nome'] }}</td>
                              <td data-title="Descrição">{{ $produtos[$i]['descricao'] }}</td>
                              <td data-title="Quantidade">{{ $quantidades[$i] }}</td>
                              <td data-title="Unidade de Venda">{{\projetoGCA\UnidadeVenda::find($produtos[$i]['unidadevenda_id'])->nome }}</td>
                              <td data-title="Preçõ">{{ 'R$ '.number_format($produtos[$i]['preco']*$quantidades[$i],2) }}</td>
                              <td data-title="Produtor">{{\projetoGCA\Produtor::find($produtos[$i]['produtor_id'])->nome}}</td>
                            </tr>
                          @endfor
                        </tbody>
                        <tfoot>
                          <tr>
                            <th colspan="5" style="text-align: right">Total</th>
                            <th colspan="5" style="text-align: right">{{'R$ '.number_format($total,2)}}</th>
                          </tr>
                        </tfoot>
                    </table>
                  </div>
                </div>
                    <div class="panel-footer">
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-13">
                            <!-- onchange="Enable(this)" -->
                              <input type="radio" onchange="show_drop_down()" id="radio_retirada" name="tipo" value="retirada" required>
                              <label for="retirada">Retirar pedido no local do evento</label><br>
                              
                              <input type="radio"  onchange="show_drop_down()" id="radio_entrega" name="tipo"  value="entrega">
                              <label for="entrega">Receber entrega a meu endereço</label><br>
                              

                                <select  class="form-control" id="select_retirada" name="localretiradaevento" >
                                    <option value="" selected disabled >Escolha local de retirada</option>
                                    @php($evento = \projetoGCA\Evento::find($evento))
                                    @foreach ($evento->locaisretiradaevento as $local)
                                        @if (old('localretiradaevento') == $local->id)
                                            <option value="{{$local->id}}"  selected>{{$local->localretirada()->withTrashed()->first()->nome}}</option>
                                        @else
                                            <option value="{{$local->id}}" >{{$local->localretirada()->withTrashed()->first()->nome}}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <select class="form-control" id="select_entrega" name="entrega_endereco" > -->
                                  <option value="" selected disabled hidden>Entrega a seu endereço</option>
                                  
                                    @if(\Auth::user()->endereco != null )
                                      @if (old('endereco') == $local->id)
                                      <option value="{{ \Auth::user()->endereco->id }}" selected> {{\Auth::user()->endereco->rua}}</option>
                                      @else
                                          <option value="{{ \Auth::user()->endereco->id }}">{{\Auth::user()->endereco->rua}}</option>
                                      @endif
                                    @endif
                                   
                                </select>

                                <br>
                                <a href="{{URL::previous()}}" class="btn btn-danger">Voltar</a>
                                <button type="submit" class="btn btn-primary">
                                    Finalizar Pedido
                                </button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')

<script type="text/javascript">

document.addEventListener("DOMContentLoaded", function(event) {
  document.getElementById("select_retirada").style.display = "none";
  document.getElementById("select_entrega").style.display = "none";
});

 

show_drop_down = function()
 {
   
  if(document.getElementById("radio_retirada").checked == true){
    document.getElementById("select_retirada").style.display = "block";

    document.getElementById("select_entrega").selectedIndex = 0;
    document.getElementById("select_entrega").style.display = "none";
      
  }
    if(document.getElementById("radio_entrega").checked == true){
    document.getElementById("select_entrega").style.display = "block";

    document.getElementById("select_retirada").selectedIndex = 0;
    document.getElementById("select_retirada").style.display = "none";

  }

  name = function() {
  
    const select_retirada = document.getElementById("select_retirada");
    const select_entrega = document.getElementById("select_entrega");

    function init() {
      
      select_retirada.addEventListener('change', checkValidity);
      select_entrega.addEventListener('change', checkValidity);
            
      checkValidity();
    }

    //Deve haver uma opção escolhida para um dos selects
    function isChecked() {
        //Checando primeiro select
        if(select_retirada.selectedIndex != 0 || select_entrega.selectedIndex != 0){
          return true;
        }
        
        return false;
    }

    function checkValidity() {
      
        const errorMessage = !isChecked() ? 'At least one checkbox must be selected.' : '';
        if(select_retirada.style.display == "none"){
          select_entrega.setCustomValidity(errorMessage);
          select_retirada.setCustomValidity("");
        }else{
          select_retirada.setCustomValidity(errorMessage); 
          select_entrega.setCustomValidity("");
        }
    }

    init();
  }();
    
}

</script>
@endsection

