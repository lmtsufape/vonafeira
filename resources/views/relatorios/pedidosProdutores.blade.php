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

    @foreach($produtores as $produtor)
      <div style="page-break-after: always">
        <h3>Relatório de Pedidos para o Produtor - Emitido em {{$date}}</h3>
        <br>

        <table>
          <thead>
            <tr>
                <th><strong>Produtor:</strong></th>
                <th colspan='3'><strong>{{$produtor->nome}}</strong></th>
            </tr>
            <tr>
              <th>PRODUTO</th>
              <th>PREÇO</th>
              <th>PORÇÃO</th>
              <th>QUANTIDADE</th>
            </tr>
          </thead>

          <tbody>
            @foreach($itensPedidos as $itemPedido)

                <?php
                  $produto = \projetoGCA\Produto::where('id','=',$itemPedido->produto_id)->first();
                  $unidadeVenda = \projetoGCA\UnidadeVenda::where('id','=',$produto->unidadevenda_id)->first();
                ?>
                @if($produto->produtor_id == $produtor->id)
                  <tr>
                    <th>{{$produto->nome}}</th>
                    <th>{{'R$'.number_format($produto->preco, 2)}}</th>

                    @if($unidadeVenda->is_porcao)
                      <th>Sim</th>
                    @else
                      <th>Não</th>
                    @endif

                    <th>{{$itemPedido->quantidade}}</th>
                  </tr>
                @endif


            @endforeach
          </tbody>
        </table>

      </div>
    @endforeach

  </body>
</html>
