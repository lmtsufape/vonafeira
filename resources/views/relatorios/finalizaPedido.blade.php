<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/relatorios.css') }}" rel="stylesheet">
    <title>Pedido Finalizado</title>
</head>
<body>
    <table class="table table-bordered">
        <thead>
            <tr><th colspan="7" style="text-align:center">
                Pedido #{{$pedido->id}}
            </th></tr>
            <tr>
                <th>Qtd.</th>
                <th>Und. Venda</th>
                <th>Produto</th>
                <th>Descrição</th>
                <th>Produtor</th>
                <th>Preço Unt.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        @php($total=0)
        <tbody>
            @foreach($pedido->itens as $item)
                <tr>
                    <td>{{$item->quantidade}}</td>
                    <td>{{$item->produto->unidadeVenda->nome}}</td>
                    <td>{{$item->produto->nome}}</td>
                    <td>{{$item->produto->descricao}}</td>
                    <td>{{$item->produto->produtor->nome}}</td>
                    <td>{{$item->produto->preco}}</td>
                    @php($total_produto = $item->quantidade*$item->produto->preco)
                    <td>{{$total_produto}}</td>
                    @php($total=$total+$total_produto)
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7" style="text-align:right">SOMA: {{$total}}</th>
            </tr
        </tfoot>
        
    </table>

</body>
</html>
