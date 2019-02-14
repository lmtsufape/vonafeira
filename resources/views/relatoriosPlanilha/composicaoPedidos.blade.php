<table class="table table-bordered">
  <thead>
      <tr>
          <th>Produto</th>
          <th>Descrição</th>
          <th>Produtor</th>
          <th>Qtd.</th>
          <th>Unidade</th>
          <th>Valor Unt.</th>
          <th>Total</th>
          <th>Consumidor</th>
          <th>Retirada</th>
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
                $local_retirada = $pedido->localretiradaevento->localretirada()->withTrashed()->first()->nome;
            ?>

            <tr>
                <td>{{$produto->nome}}</td>
                <td>{{$produto->descricao}}</td>
                <td>{{$produto->produtor()->withTrashed()->first()->nome}}</td>
                <td>{{$itemPedido->quantidade}}</td>
                <td>{{$unidadeVenda->nome}}</td>
                <td>{{'R$ '.number_format($produto->preco,2)}}</td>
                <td>{{'R$ '.number_format($valor_item,2)}}</td>
                <td>{{$consumidor->name}}</td>
                <td>{{$local_retirada}}</td>
            </tr>

          @endif

      @endforeach

    @endforeach

  </tbody>
</table>
