<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/relatorios.css') }}" rel="stylesheet">
    <title>Relatório de Pedidos para o Produtor</title>
</head>
<body>
    <h3>Relatório de Pedidos para o Produtor - Emitido em {{$date}}</h3>
    <br>
    <table>
    <thead>
        <tr>
            <th>PRODUTOR</th>
            <th>PRODUTO</th>
            <th>PREÇO</th>
            <th>PORÇÃO</th>
            <th>QUANTIDADE</th>
        </tr>
        </thead>
        <tbody>
    @for ($i = 0; $i < count($data); $i++)
        <tr>
            <th>{{$data[$i]->nome_produtor}}</th>
            <th>{{$data[$i]->nome_produto}}</th>
            <th>{{'R$'.number_format($data[$i]->preco, 2)}}</th>
            @if($data[$i]->is_porcao)
                <th>Sim</th>
            @else
                <th>Não</th>
            @endif
            <th>{{$data[$i]->quantidades}}</th>
        </tr>
    @endfor
        </tbody>
    </table>
</body>
</html>