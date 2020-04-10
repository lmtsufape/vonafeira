@extends('layouts.app')

@section('titulo','Listagem de Pedidos')

@section('navbar')
    <a href="{{ route("home") }}">Início</a> >
    <a href="{{ route("grupoConsumo.listar") }}">Grupos de Consumo</a> >
    <a href="{{ route("grupoConsumo.gerenciar", ["id" => $grupoConsumo->id]) }}">Gerenciar Grupo: {{$grupoConsumo->name}}</a> >
    <a href="{{ route("evento.listar", ["idGrupoConsumo" => $grupoConsumo->id]) }}">Eventos</a> >
    Pedidos do Evento {{$evento->id}}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Pedidos</div>
                <div class="panel-body">
                  <center>
                    @if($evento->estaAberto)
                      <button disabled class="dropbtndisabled">Relatório Montagem Pedido</button>
                      <button disabled class="dropbtndisabled">Relatório Produtor</button>
                      <button disabled class="dropbtndisabled">Relatório Consumidor</button>

                    @else

                      <div class="dropdown">
                        <button class="dropbtn">Relatório Montagem Pedido</button>
                        <div class="dropdown-content">
                          <a target="_blank" href="{{ route("evento.relatorioPDF.montagem", ["evento_id" => $evento->id]) }}">Exibir PDF</a>
                          <a target="_blank" href="{{ route("evento.relatorioPDF.montagem.download", ["evento_id" => $evento->id]) }}">Download em PDF</a>
                          <a target="_blank" href="{{ route("evento.relatorioPlanilha.montagem", ["evento_id" => $evento->id]) }}">Download em XLS</a>
                        </div>
                      </div>

                      <div class="dropdown">
                        <button class="dropbtn">Relatório Produtores</button>
                        <div class="dropdown-content">
                          <a target="_blank" href="{{ route("evento.relatorioPDF.produtores", ["evento_id" => $evento->id]) }}">Exibir PDF</a>
                          <a target="_blank" href="{{ route("evento.relatorioPDF.produtores.download", ["evento_id" => $evento->id]) }}">Download em PDF</a>
                          <a target="_blank" href="{{ route("evento.relatorioPlanilha.produtores", ["evento_id" => $evento->id]) }}">Download em XLS</a>
                        </div>
                      </div>

                      <div class="dropdown">
                        <button class="dropbtn">Relatório Consumidores</button>
                        <div class="dropdown-content">
                          <a target="_blank" href="{{ route("evento.relatorioPDF.consumidores", ["evento_id" => $evento->id]) }}">Exibir PDF</a>
                          <a target="_blank" href="{{ route("evento.relatorioPDF.consumidores.download", ["evento_id" => $evento->id]) }}">Download em PDF</a>
                          <a target="_blank" href="{{ route("evento.relatorioPlanilha.consumidores", ["evento_id" => $evento->id]) }}">Download em XLS</a>
                        </div>
                      </div>
                    @endif
                </center>
                </div>
                <div class="panel-body">
                  <div id="tabela" class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Cód.</th>
                          <th>Consumidor</th>
                          <!-- <th>Número de Itens</th> -->
                          <th>Total</th>
                          <th>Data</th>
                          <!-- <th>Tipo</th> -->
                          <!-- <th>Ações</th> -->
                          <th></th>
                        </tr>
                      </thead>
                      
                        @foreach($pedidos as $pedido)
                        <tbody>
                          <?php
                            $consumidor = \projetoGCA\User::find($pedido->consumidor->user_id);
                            $quantidade = 0;
                            $valor_pedido = 0;
                            $itens_pedido = \projetoGCA\ItemPedido::where('pedido_id','=',$pedido->id)->get();
                            foreach($itens_pedido as $item_pedido){
                              $produto = \projetoGCA\Produto::withTrashed()->find($item_pedido->produto_id);
                              $valor_pedido = $valor_pedido + $item_pedido->quantidade * $produto->preco;
                              $quantidade = $quantidade + 1;
                            }
                          ?>
                          <tr>
                            <td data-title="Cód.">{{ $pedido->id }}</td>
                            <td data-title="Consumidor">{{ $consumidor->name }}</td>
                            <!-- <td data-title="Número de Itens">{{ $quantidade }}</td> -->
                            <td data-title="Total">{{ 'R$ '.number_format($valor_pedido, 2) }}</td>
                            <td data-title="Data">{{ \projetoGCA\Http\Controllers\UtilsController::dataFormato($pedido->data_pedido, 'd/m/Y') }}</td>
                            <!-- <td>
                              <a class="btn btn-info" href="{{ route("evento.pedido.tipo", ["pedido_id" => $pedido->id]) }}">
                                @if($pedido->localretiradaevento_id != null)
                                  Retirada
                                @elseif($pedido->endereco_consumidor_id != null)
                                  Entrega
                                @else
                                  Indefinido
                                @endif
                              </a>
                            </td> -->
                            <td>
                              <!-- <a class="btn btn-info" href="{{ route("evento.pedido.itens", ["pedido_id" => $pedido->id]) }}">
                                Itens
                              </a> -->

                            <p>
                              <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#{{$pedido->id}}" aria-expanded="false" aria-controls="collapseExample">
                                Ver Detalhes
                              </button>
                          </p>
                              
                            </td>
                            
                          </tr>
                        
                          <tr >
                            <td colspan="6">
                              <div class="collapse" id="{{$pedido->id}}">
                                <div class="card card-body">
                                  <!--Informações do consumidor-->
                                  <label>Email: </label>
                                  <p>{{$consumidor != null ? $consumidor->email : ""}}</p>
                                  <label>Telefone: </label>
                                  <p>{{$consumidor != null ? $consumidor->email : ""}}</p>
                                  @if($consumidor->endereco != null)
                                    <label>Rua + num: </label>
                                    <p>{{$consumidor != null ? $consumidor->email : ""}}</p>
                                    <label>Bairro: </label>
                                    <p>{{$consumidor != null ? $consumidor->email : ""}}</p>
                                    <label>Cidade + uf: </label>
                                    <p>{{$consumidor != null ? $consumidor->email : ""}}</p>
                                  @endif
                                  <!-- Percorrer cada item do pedido -->
                                  @php($count = 1)
                                  @php($unidadeVenda = \projetoGCA\UnidadeVenda::withTrashed()->where('id','=',$produto->unidadevenda_id)->first())
                                  
                                  @foreach ($pedido->itens as $item)                          

                                    <label>{{$count++}}</label>
                                    <label>{{$item->produto->nome}}</label>
                                    <label>{{$item->quantidade}}</label>
                                    <label>{{ 'R$ '.number_format($item->produto->preco, 2) }}</label>
                                    <label>{{ 'R$ '.number_format($item->produto->preco * $item->quantidade, 2)}}</label>
                                    
                                    <p>Produzido por: {{$item->produto->produtor->nome}}</p>
                                    <p>Unidade de venda: {{$unidadeVenda->nome}}</p>

                                  @endforeach
                                </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                          
                        @endforeach
                      
                    </table>
                  </div>
                </div>
                <div class="panel-footer">


                  <a class="btn btn-danger" href="{{ route("evento.listar", ["idGrupoConsumo" => $grupoConsumo->id]) }}">
                    Voltar
                  </a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
