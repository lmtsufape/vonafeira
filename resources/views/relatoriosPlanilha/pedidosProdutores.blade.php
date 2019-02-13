@foreach($produtores as $produtor)

  @php($total=0)

  <div style="page-break-after: always">
    <table class="table table-bordered">
      <thead>
        <tr>
            <th colspan="6" style="text-align:center"><strong>Produtor: {{$produtor->nome}}</strong></th>
        </tr>
        <tr>
          <th>Qtd.</th>
          <th>Produto</th>
          <th>Descrição</th>
          <th>Und. Venda</th>
          <th>Preço Unt.</th>
          <th>Subtotal</th>
        </tr>
      </thead>

      <tbody>

        @php($total=0)
        @foreach($produtos as $produto)

          <?php
            $unidadeVenda = \projetoGCA\UnidadeVenda::withTrashed()->where('id','=',$produto->unidadevenda_id)->first();
          ?>

          @if($produto->produtor_id == $produtor->id)


            @php($subtotal=0)
            @php($quantidade=0)

            @if($unidadeVenda->is_porcao == false)
              <?php
                foreach($itensPedidos as $itemPedido){
                  if($itemPedido->produto()->withTrashed()->first() == $produto){
                    $quantidade = $quantidade + $itemPedido->quantidade;
                    $subtotal = $quantidade*$produto->preco;
                  }
                }

                $total = $total + $subtotal;
              ?>

              <tr>
                <td>{{$quantidade}}</td>
                <td>{{$produto->nome}}</td>
                <td>{{$produto->descricao}}</td>
                <td>{{$unidadeVenda->nome}}</td>
                <td>{{'R$ '.number_format($produto->preco, 2)}}</td>
                <td>{{'R$ '.number_format($subtotal,2)}}</td>
              </tr>

            @else

              @foreach($itensPedidos as $itemPedido)
                @if($itemPedido->produto()->withTrashed()->first() == $produto){
                  <?php
                    $quantidade = $itemPedido->quantidade;
                    $subtotal = $quantidade*$produto->preco;

                    $total = $total + $subtotal;
                  ?>

                  <tr>
                    <td>{{$quantidade}}</td>
                    <td>{{$produto->nome}}</td>
                    <td>{{$produto->descricao}}</td>
                    <td>{{$unidadeVenda->nome}}</td>
                    <td>{{'R$ '.number_format($produto->preco, 2)}}</td>
                    <td>{{'R$ '.number_format($subtotal,2)}}</td>

                  </tr>
                @endif
              @endforeach

            @endif


          @endif
        @endforeach

        <tr>
            <td colspan="6" style="text-align:right"><strong>Valor total:</strong> {{'R$ '.number_format($total,2)}}</td>
        </tr>
      </tbody>
    </table>
  </div>
@endforeach
