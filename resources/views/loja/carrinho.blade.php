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
                              <input type="radio" onchange="check()" id="radio_retirada" name="destino" value="retirada">
                              <label for="retirada">Retirar em local</label><br>
                              
                              <input type="radio"  onchange="check()" id="radio_entrega" name="destino"  value="entrega">
                              <label for="entrega">Entregar a meu endereço</label><br>
                              

                                <select  class="form-control" id="select_retirada" name="localretiradaevento" required>
                                    <option value="" selected disabled hidden>Escolha local de retirada</option>
                                    @php($evento = \projetoGCA\Evento::find($evento))
                                    @foreach ($evento->locaisretiradaevento as $local)
                                        @if (old('localretiradaevento') == $local->id)
                                            <option value="{{$local->id}}"  selected>{{$local->localretirada()->withTrashed()->first()->nome}}</option>
                                        @else
                                            <option value="{{$local->id}}" >{{$local->localretirada()->withTrashed()->first()->nome}}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <select class="form-control" id="select_entrega" name="entrega_endereco"> -->
                                  <option value="" selected disabled hidden>Entrega a seu endereço</option>
                                  
                                    @if(\Auth::user()->endereco != null )
                                      @if (old('endereco') == $local->id)
                                      <option value="{{ \Auth::user()->endereco }}" selected> {{\Auth::user()->endereco->rua}}</option>
                                      @else
                                          <option value="{{ \Auth::user()->endereco }}">{{\Auth::user()->endereco->rua}}</option>
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
  // do your stuff here
  document.getElementById("select_retirada").style.display = "none";
  document.getElementById("select_entrega").style.display = "none";
});

 
check = function()
 {
   //console.log(document.getElementById("radio_retirada"));
      // if(document.getElementById("radio_retirada").checked == true){

      //   var options = document.getElementById("select_retirada").options;

      //   console.log(options);
      // }
      if(document.getElementById("radio_retirada").checked == true){
        console.log("true");
        // var options = 
        document.getElementById("select_retirada").style.display = "block";
        document.getElementById("select_entrega").style.display = "none";
        // .options;
        // for(opcao in options){
        //   opcao.removeAttribute("hidden");
        // }   
      }
       if(document.getElementById("radio_entrega").checked == true){
        console.log("true 2");
        document.getElementById("select_entrega").style.display = "block";
        document.getElementById("select_retirada").style.display = "none";
      }
  }

</script>
@endsection

