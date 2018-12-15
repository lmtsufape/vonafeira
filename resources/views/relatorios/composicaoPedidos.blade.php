<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/relatorios.css') }}" rel="stylesheet">
    <title>Relatório de Composição de Pedidos.pdf</title>
</head>
<body>
    <h3>Relatório de Composição de Pedidos - Emitido em {{$data}}</h3>

    @foreach($consumidores as $consumidor)
        <div style="page-break-after: always">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="4" style="text-align:center"><strong>Consumidor: {{$consumidor->name}}</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @php($total=0)
                    @foreach($pedidos as $pedido)
                        @if($pedido->consumidor_id == $consumidor->id)
                            <tr><th colspan="4">Pedido #{{$pedido->id}}</th></tr>
                            <tr>
                                <th>Quantidade</th>
                                <th>Produto</th>
                                <th>Preço Unitário</th>
                                <th>Subtotal</th>
                            </tr>
                            @php($subtotal=0)
                            @php($itensPedido = \projetoGCA\ItemPedido::where('pedido_id','=',$pedido->id)->get())
                            @foreach($itensPedido as $itemPedido)
                                <?php
                                    $produto = \projetoGCA\Produto::find($itemPedido->produto_id);
                                    $subtotal_item = $itemPedido->quantidade*$produto->preco;
                                    $subtotal = $subtotal + $subtotal_item;
                                ?>
                                <tr>
                                    <td>{{$itemPedido->quantidade}}</td>
                                    <td>{{$produto->nome}}</td>
                                    <td>{{'R$'.number_format($produto->preco, 2)}}</td>
                                    <td>{{'R$'.number_format($subtotal_item,2)}}</td>                                    
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" style="text-align:left"><strong>Subtotal do Pedido:</strong> {{'R$'.number_format($subtotal,2)}}</td>
                                @php($total = $total+$subtotal)
                            </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td colspan="4" style="text-align:right"><strong>Valor total:</strong> {{'R$'.number_format($total,2)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>       
    @endforeach
</body>
</html>