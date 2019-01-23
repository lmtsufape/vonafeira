<?php

namespace projetoGCA\Http\Middleware;

use Closure;
use Auth;

class AutorizacaoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(\Auth::guest()){

            return redirect('login');

        }else{

            $rotas_coordenador = [
                //Unidade de Venda
                'unidadesVenda/{grupoConsumoId}',
                'adicionarUnidadeVenda/{grupoConsumoId}',
                'editarUnidadeVenda/{grupoConsumoId}/{id}',
                //Produto
                'adicionarProduto/{idGrupoConsumo}',
                'produtos/{idGrupoConsumo}',
                //Produtor
                'adicionarProdutor/{idGrupoConsumo}',
                'produtores/{idGrupoConsumo}',
                //Consumidor
                'consumidores/{idGrupoConsumo}',
                //Grupo de Consumo
                'editarGrupoConsumo/{id}',
                'gerenciar/{id}',
                //Evento
                'adicionarEvento/{idGrupoConsumo}',
                'eventos/{idGrupoConsumo}'
            ];

            $rotas_pedidos = [
                'meusPedidos/{pedido_id}',
                'visualizarPedido/{id}'
            ];

            $rotas_pedidos_evento_aberto = [
                'editarPedido/{id}',
                'cancelarPedido/{id}',
            ];

            $rotas_evento_coordenador = [
                'evento/pedidos/{evento_id}',
                'evento/fechar/{eventoId}',
            ];

            $rotas_relatorios = [
                'evento/pedidos/relatorioProdutor/{evento_id}',
                'evento/pedidos/relatorioConsumidor/{evento_id}',
                'evento/pedidos/relatorioComposicao/{evento_id}'

            ];

            $rotas_produto_coordenador = [
                'editarProduto/{idProduto}',
                'removerProduto/{idProduto}',
            ];

            $rotas_produtor_coordenador = [
                'editarProdutor/{idProdutor}',
                'removerProdutor/{idProdutor}',
            ];

            if(in_array($request->route()->uri,$rotas_coordenador)){

                $grupoConsumoIdNomes = ['grupoConsumoId','id','idGrupoConsumo'];
                $grupoConsumo = NULL;
                foreach ($grupoConsumoIdNomes as $id){
                    if(\projetoGCA\GrupoConsumo::find($request->route($id)) != NULL){
                        $grupoConsumo = \projetoGCA\GrupoConsumo::find($request->route($id));
                        break;
                    }
                }
                if($grupoConsumo == NULL || \Auth::user()->id != $grupoConsumo->coordenador_id){
                    return redirect("/home");
                }

            }else if(in_array($request->route()->uri,$rotas_pedidos)){

                $pedidoIdNomes = ['id','pedido_id'];
                $pedido = NULL;
                foreach($pedidoIdNomes as $id){
                    if(\projetoGCA\Pedido::find($request->route($id)) != NULL){
                        $pedido = \projetoGCA\Pedido::find($request->route($id));
                    }
                }
                if($pedido == NULL){
                    return redirect("/home");
                }else{
                    $user = \projetoGCA\User::find($pedido->consumidor->user_id);
                    if($user->id != \Auth::user()->id){
                        return redirect("/home");
                    }
                }

            }else if(in_array($request->route()->uri,$rotas_pedidos_evento_aberto)){

                $pedidoIdNomes = ['id'];
                $pedido = NULL;
                foreach($pedidoIdNomes as $id){
                    if(\projetoGCA\Pedido::find($request->route($id)) != NULL){
                        $pedido = \projetoGCA\Pedido::find($request->route($id));
                    }
                }

                if($pedido == NULL){
                    return redirect("/home");
                }

                $evento = \projetoGCA\Evento::find($pedido->evento_id);

                if($evento->estaAberto == False){
                  return redirect("/home");
                }else{
                  $user = \projetoGCA\User::find($pedido->consumidor->user_id);
                  if($user->id != \Auth::user()->id){
                      return redirect("/home");
                  }
                }

            }elseif(in_array($request->route()->uri,$rotas_evento_coordenador)){

                $eventoIdNomes = ['evento_id','eventoId'];
                $evento = NULL;
                foreach($eventoIdNomes as $id){
                    if(\projetoGCA\Evento::find($request->route($id)) != NULL){
                        $evento = \projetoGCA\Evento::find($request->route($id));
                    }
                }
                if($evento == NULL || \Auth::user()->id != $evento->coordenador_id ){
                    return redirect('/home');
                }

            }elseif(in_array($request->route()->uri,$rotas_relatorios)){

                $eventoIdNomes = ['evento_id','eventoId'];
                $evento = NULL;
                foreach($eventoIdNomes as $id){
                    if(\projetoGCA\Evento::find($request->route($id)) != NULL){
                        $evento = \projetoGCA\Evento::find($request->route($id));
                    }
                }
                if($evento == NULL || $evento->estaAberto || \Auth::user()->id != $evento->coordenador_id ){
                    return redirect('/home');
                }

            }elseif($request->route()->uri == 'removerUnidadeVenda/{id}'){

                $unidadeVenda = \projetoGCA\UnidadeVenda::find($request->route('id'));
                if($unidadeVenda == NULL){
                    return redirect("/home");
                }
                $grupoConsumo = \projetoGCA\GrupoConsumo::find($unidadeVenda->grupoConsumoId);
                if($grupoConsumo == NULL || \Auth::user()->id != $grupoConsumo->coordenador_id){
                    return redirect("/home");
                }

            }elseif($request->route()->uri == 'removerProdutoPedido/{idItemPedido}'){

                $itemPedido = \projetoGCA\ItemPedido::find($request->route('idItemPedido'));
                $pedido = NULL;
                if($itemPedido != NULL){
                    $pedido = \projetoGCA\Pedido::find($itemPedido->pedido_id);
                }
                if($pedido == NULL){
                    return redirect("/home");
                }else{
                    $consumidor = \projetoGCA\Consumidor::find($pedido->consumidor_id);
                    if($consumidor->user_id != \Auth::user()->id){
                        return redirect("/home");
                    }
                }

            }elseif($request->route()->uri == 'grupoconsumo/sair/{grupoConsumoId}'){

                $consumidores = \projetoGCA\Consumidor::where('user_id','=',\Auth::user()->id)->get();
                $is_consumidor = false;
                foreach($consumidores as $consumidor){
                    if($consumidor->grupo_consumo_id == $request->route('grupoConsumoId')){
                        $is_consumidor = true;
                    }
                }
                if($is_consumidor == false){
                    return redirect("/home");
                }

            }elseif($request->route()->uri == 'evento/pedidos/itens/{pedido_id}'){

                $pedido = \projetoGCA\Pedido::find($request->route('pedido_id'));
                if($pedido == NULL){
                    return redirect('/home');
                }
                $evento = \projetoGCA\Evento::find($pedido->evento_id);
                if($evento == NULL){
                    return redirect('/home');
                }
                if(\Auth::user()->id != $evento->coordenador_id){
                    return redirect('/home');
                }

            }elseif($request->route()->uri == 'loja/evento/{id}'){

                $evento = \projetoGCA\Evento::find($request->route('id'));
                if($evento == NULL){
                    dd('Redirect');
                    return redirect('/home');
                }
                $grupoConsumo = \projetoGCA\GrupoConsumo::find($evento->grupoconsumo_id);
                if($grupoConsumo == NULL){
                    dd('Redirect');

                    return redirect('/home');
                }
                $consumidores = \projetoGCA\Consumidor::where('user_id','=',\Auth::user()->id)->get();
                $is_consumidor = false;
                foreach($consumidores as $consumidor){
                    if($consumidor->grupo_consumo_id == $grupoConsumo->id){
                        $is_consumidor = true;
                    }
                }
                if($is_consumidor == false){
                    dd('redirect');
                    return redirect("/home");
                }

            }elseif(in_array($request->route()->uri,$rotas_produto_coordenador)){

                $produto = NULL;

                if(\projetoGCA\Produto::find($request->route('idProduto')) != NULL){
                    $produto = \projetoGCA\Produto::find($request->route('idProduto'));
                }

                if(\Auth::user()->id != $produto->grupoConsumo->coordenador_id){
                    return redirect("/home");
                }
            }elseif(in_array($request->route()->uri,$rotas_produtor_coordenador)){

                $produtor = NULL;

                if(\projetoGCA\Produtor::find($request->route('idProdutor')) != NULL){
                    $produtor = \projetoGCA\Produtor::find($request->route('idProdutor'));
                }

                if(\Auth::user()->id != $produtor->grupoConsumo->coordenador_id){
                    return redirect("/home");
                }

            }

        }

        return $next($request);
    }
}
