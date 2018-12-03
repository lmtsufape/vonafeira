<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/relatorios.css') }}" rel="stylesheet">
    <title>Relatório de Composição de Pedidos</title>
</head>
<body>
    <h3>Relatório de Composição de Pedidos - Emitido em {{$date}}</h3>
    @foreach($data as $pedido)
    @php ($total = 0)
    <strong>Consumidor: </strong> {{$pedido->consumidor->usuario->name}}
    <table>
        <thead>
            <tr>
                <th>PRODUTO</th>
                <th>PRECO</th>
                <th>QUANTIDADE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedido->itens as $item)
            <tr>
                <th>{{$item->nome_produto}}</th>
                <th>{{'R$'.number_format($item->preco, 2)}}</th>
                <th>{{$item->quantidades}}</th>
            </tr>
            @php ($total = $total + $item->preco*$item->quantidades)
            @endforeach
        </tbody>
        <tfoot>
        <tr>
                <th><strong>Total</strong></th>
                <th>{{'R$'.number_format($total, 2)}}</th>
                <th></th>
            </tr>
        </tfoot>
    
    
    </table>

    <br>
    @endforeach
</body>
</html>