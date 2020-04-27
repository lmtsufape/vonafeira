<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/relatorios-consumidor.css') }}" rel="stylesheet">
    <title>Relatório de Pedidos para o Consumidor.pdf</title>
</head>
<body>
    <h3 class="centralizar">Relatório de Pedidos para o Consumidor - Emitido em {{$data}}</h3>
    @php($total_evento = 0)
    @foreach($consumidores as $consumidor)
        <div style="page-break-after: always">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="7" style="text-align:center" class="bg-dark">Consumidor: {{ $consumidor->name }}</th>
                    </tr>
                    <tr class="bg-white">
                        <th colspan="3">Telefone: {{$consumidor->telefone}}<br/>
                        Email: {{$consumidor->email}}</th>
                        @if( $consumidor->endereco != null)
                            <th colspan="4">Rua: {{$consumidor->endereco->rua}} 
                                @if( $consumidor->endereco->numero != null)
                                    {{''. ', nº ' .$consumidor->endereco->numero }}
                                @endif
                                <br/>Bairro: {{$consumidor->endereco->bairro}}
                                <br/>Cidade: {{$consumidor->endereco->cidade . '-' . $consumidor->endereco->uf}}
                            </th>
                        @else
                            <th colspan="4" class="centralizar">Não há endereço cadastrado</th>                        
                        @endif
                    </tr>
                    <tr><td colspan="7" class="sem-borda"></td></tr>
                </thead>
                <tbody>
                    @php($total=0)
                    @foreach($pedidos as $pedido)
                        @if($pedido->consumidor->user_id == $consumidor->id)
                            <tr><th colspan="7" class="bg-white">Pedido #{{$pedido->id}} | 
                                @if($pedido->localretiradaevento_id != null)
                                    Retirada no local do evento - {{$pedido->localretiradaevento->localretirada()->withTrashed()->first()->nome}}
                                @elseif($pedido->endereco_consumidor_id != null)
                                    @if($pedido->endereco != $consumidor->endereco)
                                        Entrega no endereço: Rua: $pedido->endereco->rua {{$pedido->endereco->numero != null ? ''.', '.$pedido->endereco->numero:''}}</br>
                                        Bairro: $pedido->endereco->bairro</br>
                                        Cidade: $pedido->endereco->cidade . '-' . $pedido->endereco->uf
                                    @else
                                        Entrega no endereço do consumidor
                                    @endif                                    
                                @else
                                    Local - Indefinido
                                @endif
                            </th></tr>
                            <tr class="bg-medium">
                                <th>Qtd.</th>
                                <th>Und. Venda</th>
                                <th>Produto</th>
                                <th>Descrição</th>
                                <th>Produtor</th>
                                <th>Preço Unt.</th>
                                <th>Subtotal</th>
                            </tr>
                            @php($subtotal=0)
                            @php($itensPedido = \projetoGCA\ItemPedido::where('pedido_id','=',$pedido->id)->get())
                            @foreach($itensPedido as $itemPedido)
                                <?php
                                    $produto = \projetoGCA\Produto::withTrashed()->where('id','=',$itemPedido->produto_id)->first();
                                    $unidadeVenda = \projetoGCA\UnidadeVenda::withTrashed()->where('id','=',$produto->unidadevenda_id)->first();
                                    $produtor = \projetoGCA\Produtor::withTrashed()->where('id','=',$produto->produtor_id)->first();
                                    $subtotal_item = $itemPedido->quantidade*$produto->preco;
                                    $subtotal = $subtotal + $subtotal_item;
                                ?>
                                <tr>
                                    <td>{{$itemPedido->quantidade}}</td>
                                    <td>{{$unidadeVenda->nome}}
                                    <td>{{$produto->nome}}</td>
                                    <td>{{$produto->descricao}}</td>
                                    <td>{{$produtor->nome}}</td>
                                    <td>{{'R$ '.number_format($produto->preco, 2)}}</td>
                                    <td>{{'R$ '.number_format($subtotal_item,2)}}</td>
                                </tr>
                            @endforeach
                            <tr class="bg-medium">
                                <td colspan="6" style="text-align:right"><strong>Subtotal do Pedido:</strong></td>
                                <td>{{'R$ '.number_format($subtotal,2)}}</td>
                                @php($total = $total+$subtotal)
                            </tr>
                            <tr><td colspan="7" class="sem-borda"></td></tr>
                        @endif
                    @endforeach
                    <tr>
                        <td colspan="7" style="text-align:right"><strong>Valor total:</strong> {{'R$ '.number_format($total,2)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @php($total_evento = $total_evento + $total)
    @endforeach
    <table class="table table-bordered">
        <thead>
            <th colspan="6" style="text-align: center"><h1>Valor total do evento: {{'R$ '.number_format($total_evento, 2)}}</h1></th>
        </thead>
    </table>
</body>
</html>
