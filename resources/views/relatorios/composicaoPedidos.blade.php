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
    <h3>Relatório de Composição de Pedidos - Emitido em {{$date}}</h3>

    <?php

    $consumidores = array();
    foreach ($data as $pedido) {
        $consumidor = $pedido->consumidor;
        if(!in_array($consumidor,$consumidores)){
            array_push($consumidores,$consumidor);
        } 
    }

    $pedidos = $data;

    //dd($consumidores);

    ?>

    @foreach($consumidores as $consumidor)

        <br>

        <table>
            <thead>
                <tr>
                    <th><strong>Consumidor:</strong></th>
                    <th colspan='3'><strong>{{$consumidor->usuario->name}}</strong></th>
                </tr>
                <tr>
                    <th>Quantidade</th>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
            @php($total = 0)
            @foreach($pedidos as $pedido)
                @php($subtotal = 0)
                @if($pedido->consumidor->id == $consumidor->id)
                    @foreach($pedido->itens as $item)
                    <tr>
                    <td>{{$item->quantidades}}</td>
                    <td>{{$item->nome_produto}}</td>
                    <td>{{'R$'.number_format($item->preco, 2)}}</td>
                    @php($subtotal = $item->quantidades * $item->preco)
                    <td>{{'R$'.number_format($subtotal, 2)}}</td>
                    @php($total = $subtotal + $total)
                </tr>
            @endforeach

            @endif

        @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <th colspan='3' style='text-align: right'><strong>Total</strong></th>
                    <th>{{'R$'.number_format($total, 2)}}</th>
                </tr>
            </tfoot>
        </table>

        </table>

        <br>

    @endforeach

</body>
</html>