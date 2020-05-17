@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet"/>
@stop

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
    <!-- <div class="row"> -->
        <div class="col-md-10 col-md-offset-1">
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
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead >
                        <tr id="table-header">
                          <th>Cód.</th>
                          <th>Consumidor</th>
                          <th>Número de Itens</th>
                          <th>Total</th>
                          <th>Data</th>
                          <!-- <th>Tipo</th> -->
                          <th>Ações</th>
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
                            <td data-title="Consumidor"><label>{{ $consumidor->name }}</label></td>
                            <td data-title="Número de Itens">{{ $quantidade }}</td> 
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

                          <tr id="detalhes" >
                            <td colspan="6">
                              <div class="collapse" id="{{$pedido->id}}">
                                <div class="card card-body" id="card">
                                  <!--Informações do consumidor-->
                                  <div id="info-consumidor">
                                    <h4>Dados do Consumidor</h4></br>
                                    <span class="atributo">Nome: </span>
                                    {{$consumidor != null ? $consumidor->name : ""}} </br>
                                    <span class="atributo">Email: </span>
                                    {{$consumidor != null ? $consumidor->email : ""}} </br>
                                    <span class="atributo" name="telefone" >Telefone: </span>
                                    {{$consumidor != null ? $consumidor->telefone : ""}} </br>
                                    @if($consumidor != null && $consumidor->endereco != null)
                                      @php($end = $consumidor->endereco)
                                      <span class="atributo">Rua: </span>
                                      {{ $end->rua }}
                                      @if($end->numero != null)
                                        {{''. ', nº '. $end->numero}}
                                      @endif </br>
                                      <span class="atributo">Bairro: </span>
                                      {{ $end->bairro }} </br>
                                      <span class="atributo">Cidade: </span>
                                      {{ $end->cidade . '-' . $end->uf }} </br>
                                    @endif
                                  </div>

                                  <!-- Percorrer cada item do pedido -->  
                                  @php($unidadeVenda = \projetoGCA\UnidadeVenda::withTrashed()->where('id','=',$produto->unidadevenda_id)->first())                
                                  <div id="pedidos">
                                    <h4>Dados do Pedido</h4></br>
                                    <h4>
                                      @if($pedido->localretiradaevento_id != null)
                                        <span class="atributo">Retirada no local do evento</span> - {{$pedido->localretiradaevento->localretirada()->withTrashed()->first()->nome}}
                                      @elseif($pedido->endereco_consumidor_id!= null)
                                        <span class="atributo">Entrega no endereço do consumidor</span>
                                      @else
                                        Local - Indefinido
                                      @endif
                                    </h4></br>
                                    <table class="table table-sm" id="table-pedidos">
                                      <thead>
                                        <tr  id="header-pedidos">
                                          <th scope="col">#</th>
                                          <th scope="col">PRODUTO</th>
                                          <th scope="col">QTD</th>
                                          <th scope="col">PREÇO</th>
                                          <th scope="col">TOTAL</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      @php($count=1)
                                      @foreach ($pedido->itens as $item)
                                        <tr>
                                          <th scope="row">{{$count++}}</th>
                                          <div class="tooltip">
                                            <td><span class="atributo" >{{$item->produto->nome}}</span>
                                            <span class="tooltiptext">Tooltip text</span></td>
                                          </div>
                                          <td><span class="atributo">{{$item->quantidade}}</span></td>
                                          <td><span class="atributo">{{ 'R$ '.number_format($item->produto->preco, 2) }}</span></td>
                                          <td><span class="atributo">{{ 'R$ '.number_format($item->produto->preco * $item->quantidade, 2)}}</span></td>
                                        </tr>
                                        <tr>
                                          <td class="td-sem-borda"></td>
                                          <td colspan="4" class="td-sem-borda"><span class="atributo">Produzido por:</span> {{$item->produto->produtor->nome}}</td>
                                        </tr>
                                        <tr>
                                          <td class="td-sem-borda"></td>
                                          <td colspan="4" class="td-sem-borda"><span class="atributo">Unidade de venda:</span> {{$unidadeVenda->nome}}</td>
                                        </tr>
                                      @endforeach
                                      <tr>
                                          <td ></td>
                                          <td ></td>
                                          <td ></td>
                                          <td ><span class="atributo">Total:</td>
                                          <td><span class="atributo">{{'R$ '.number_format($valor_pedido, 2)}}</span></td>
                                        </tr>
                                       
                                      </tbody>
                                    </table>
                                   
                                  </div>
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
    <!-- </div> -->
</div>
@endsection
