
 @extends('layouts.app')

 @section('titulo','Finalizado')

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
               <div class="panel-heading">Pedido Finalizado</div>
               <div class="panel-body">
                 <div id="tabela" class="table-responsive">
                   <table class="table table-hover">
                     <thead>
                       <tr>
                           <th colspan="8">{{'Pedido #'.$pedido->id}}</th>
                       </tr>
                       <tr>
                           <th>Produto</th>
                           <th>Descrição</th>
                           <th>Produtor</th>
                           <th>Quantidade</th>
                           <th>Un. Venda</th>
                           <th>Preço Un.</th>
                           <th>Subtotal</th>
                           <th>Tipo do pedido</th>
                           <th>Local</th>
                       </tr>
                     </thead>
                     <tbody>
                       @php($total = 0)
                       @foreach($itens_pedido as $item)
                         <tr>
                           <?php
                               $produto = $item->produto;
                               $unidadeVenda = $produto->unidadeVenda;
                               $total_item = $produto->preco * $item->quantidade;
                               $total = $total + $total_item
                           ?>
                           <td data-title="Produto">{{$produto->nome}}</td>
                           <td data-title="Descrição">{{$produto->descricao}}</td>
                           <td data-title="Produtor">{{$produto->produtor->nome}}</td>
                           <td data-title="Quantidade">{{$item->quantidade}}</td>
                           <td data-title="Un. Venda">{{$unidadeVenda->nome}}</td>
                           <td data-title="Preço Un,">{{'R$ '.number_format($produto->preco,2)}}</td>
                           <td data-title="Subtotal">{{'R$ '.number_format($total_item,2)}}</td>
                          
                           @if( $pedido->endereco_consumidor_id != null )
                            <td data-title="Tipo do pedido">Entrega</td>
                            <td data-title="Local">{{ $pedido->consumidor->usuario->endereco->rua }}</td>
                           @elseif( $pedido->localretiradaevento_id != null)
                            <td data-title="Tipo do pedido">Retirada</td>
                            <td data-title="Local">{{ $pedido->localretiradaevento->localretirada()->withTrashed()->first()->nome  }}</td>
                           @endif

                         </tr>
                       @endforeach
                     </tbody>
                     <tfoot>
                       <tr>
                         <th colspan="9" style="text-align:right">Total: {{'R$ '.number_format($total,2)}}</th>
                       </tr>
                     </tfoot>
                   </table>

                   <a href="{{ route("home") }}" class='btn btn-primary'>Início</a>
                   <a href="{{ route("consumidor.pedido.editar", ["id" => $pedido->id]) }}" class='btn btn-primary'>Editar Pedido</a>
                   <a href="{{ route("consumidor.meusPedidos") }}" class='btn btn-primary'>Meus Pedidos</a>
                 </div>
               </div>
           </div>
       </div>
   </div>
 </div>


 @endsection
