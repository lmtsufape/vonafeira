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

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Produto</th>
                <th>Descrição</th>
                <th>Produtor</th>
                <th>Qtd.</th>
                <th>Unidade</th>
                <th>Valor Unt.</th>
                <th>Total</th>
                <th>Consumidor</th>
                <!-- <th>Retirada</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach($produtos as $produto)

                @foreach($itensPedido as $itemPedido)

                    @if($itemPedido->produto_id == $produto->id)

                        <?php
                            $unidadeVenda = \projetoGCA\UnidadeVenda::find($produto->unidadevenda_id);
                            $valor_item = $itemPedido->quantidade * $produto->preco;
                            $pedido = $itemPedido->pedido;
                            $consumidor = $pedido->consumidor->usuario;
                            if($pedido->localretiradaevento != null){
                                $local_retirada = $pedido->localretiradaevento->localretirada()->withTrashed()->first()->nome;
                            }
                        ?>

                        <tr>
                            <td>{{$pedido->id}}</td>
                            <td>{{$produto->nome}}</td>
                            <td>{{$produto->descricao}}</td>
                            <td>{{$produto->produtor()->withTrashed()->first()->nome}}</td>
                            <td>{{$itemPedido->quantidade}}</td>
                            <td>{{$unidadeVenda->nome}}</td>
                            <td>{{'R$ '.number_format($produto->preco,2)}}</td>
                            <td>{{'R$ '.number_format($valor_item,2)}}</td>
                            <td>{{$consumidor->name}}</td>
                        </tr>
                        <tr>
                            @if($pedido->localretiradaevento_id != null)
                                <td colspan="4">Retirada no local do evento: </td>
                                <td colspan="5">{{$local_retirada}}</td>
                            @elseif($pedido->endereco_consumidor_id!= null)
                                <td colspan='4'>Entrega no endereço do consumidor: </td>
                                @php($end = $consumidor->endereco)
                                    <td colspan='5'>Rua: {{ $end->rua }}                               
                                    @if($end->numero != null)
                                        {{''. ', nº '. $end->numero}}
                                    @endif
                                <br/>Bairro: {{ $end->bairro }}
                                <br/>Cidade: {{ $end->cidade . '-' . $end->uf }}</td>                                      
                            @else Local - Indefinido @endif
                        </tr>
                        <tr>
                            <td colspan="9" id="ultima-linha"></td>
                        </tr>

                    @endif

                @endforeach

            @endforeach

        </tbody>
    </table>

</body>
</html>
