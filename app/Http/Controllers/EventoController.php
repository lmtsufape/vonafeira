<?php

namespace projetoGCA\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DateTime;
use DateInterval;
use Illuminate\Http\Request;

class EventoController extends Controller
{

    public function novo($idGrupoConsumo){
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($idGrupoConsumo);
        $locaisretirada = \projetoGCA\LocalRetirada::where('grupoconsumo_id','=',$idGrupoConsumo)->get();

        return view('evento.adicionarEvento', [
            'grupoConsumo' => $grupoConsumo,
            'locaisretirada' => $locaisretirada,
        ]);
    }
    /**
     * @Deprecated
     */
    public function adicionar($idGrupoConsumo){
        $dataProximoEvento = new DateTime();
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($idGrupoConsumo);
        $evento = new \projetoGCA\Evento();
        $dataAtual = new DateTime();
        $evento->coordenador_id = $grupoConsumo->coordenador_id;
        $evento->grupoconsumo_id = $grupoConsumo->id;
        $evento->data_inicio_pedidos = $dataAtual->format('Y-m-d');
        $evento->hora_evento = "08:00";
        $ultimoEvento = \projetoGCA\Evento::where('grupoconsumo_id', '=', $grupoConsumo->id)->orderBy('id', 'DESC')->first();
        if(!is_null($ultimoEvento)){
            $dataUltimoEvento = new DateTime($ultimoEvento->data_evento);
            if($dataAtual < $dataUltimoEvento){
                return "<h1>Existe um evento a ser realizado</h1>";
            }
            $dataProximoEvento = $dataUltimoEvento;
        }
        else{
            $dataProximoEvento = new DateTime($grupoConsumo->dia_semana);
        }
        if($grupoConsumo->periodo == 'Semanal'){
            // incrementa a data em uma semana
            if($dataAtual >= $dataProximoEvento){
                $dataProximoEvento->modify('+1 week');
            }
            $evento->data_evento = $dataProximoEvento->format('Y-m-d');
            // calcula a data limite dos pedidos de venda
            $intervalo = new DateInterval("P{$grupoConsumo->prazo_pedidos}D");
            $dataProximoEvento->sub($intervalo);
            // adiciona a data limite de pedidos e salva
            // return var_dump($dataProximoEvento);
            $evento->data_fim_pedidos = $dataProximoEvento->format('Y-m-d');
        }
        elseif($grupoConsumo->periodo == 'Mensal'){
            // incrementa a data em um mês
            $dataProximoEvento->modify('+1 month');
            $evento->data_evento->$dataProximoEvento;
            // calcula o intervalo limite de pedidos
            $dataPadrao = new DateTime($grupoConsumo->dia_semana);
            $dataPedidos = new DateTime($grupoConsumo->data_pedidos);
            $intervalo = $dataPadrao->diff($dataPedidos);
            $dataProximoEvento->sub($intervalo);
            // adiciona a data limite de pedidos e salva;
            $evento->data_fim_pedidos = $dataProximoEvento;
        }

        $evento->estaAberto = True;

        $evento->save();

        return redirect("/eventos".$grupoConsumo->id);

    }

    public function cadastrar(Request $request){

        $validator = Validator::make($request->all(), [
            'data_evento' => 'required',
            'hora_evento' => 'required',
            'locais' => 'required_without:checkbox_outro',
            'input_outro' => 'required_if:checkbox_outro,on',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $dataHoje = new DateTime();
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($request->id_grupo_consumo);

        $ultimoEvento = \projetoGCA\Evento::where('grupoconsumo_id', '=', $grupoConsumo->id)->orderBy('id', 'DESC')->first();
        // return var_dump(empty($ultimoEvento));

        $dataEvento = new DateTime($request->data_evento);
        $dataAtual = new DateTime();
        //return gettype($dataAtual);
        if($dataEvento < $dataAtual){
            return back()->withInput()->withErrors(['data_evento' => 'Data do evento não pode ser anterior à data atual']);
        }

        if(!is_null($ultimoEvento)){
            $eventoAberto = $ultimoEvento->estaAberto;
            if($eventoAberto == True){
                return redirect()
                        ->action('EventoController@listar', $grupoConsumo->id)
                        ->with('warning', 'Existe um evento ainda não fechado.');
            }
        }

        $evento = new \projetoGCA\Evento();
        $evento->coordenador_id = $grupoConsumo->coordenador_id;
        $evento->grupoconsumo_id = $grupoConsumo->id;
        $evento->data_evento = $request->data_evento;
        $evento->hora_evento = $request->hora_evento;

        $evento->data_inicio_pedidos = $dataHoje->format('Y-m-d');
        // calcula a data limite dos pedidos de venda
        $intervalo = new DateInterval("P{$grupoConsumo->prazo_pedidos}D");
        $dataFimPedidos = new DateTime($evento->data_evento);
        $dataFimPedidos->sub($intervalo);
        $evento->data_fim_pedidos = $dataFimPedidos->format('Y-m-d');




        $evento->estaAberto = True;
        $evento->save();

        if($request->input_outro != NULL){
            $localretirada = new \projetoGCA\LocalRetirada();
            $localretirada->nome = $request->input_outro;
            $localretirada->grupoconsumo_id = $request->id_grupo_consumo;
            $localretirada->save();

            $localretirada_evento = new \projetoGCA\LocalRetiradaEvento();
            $localretirada_evento->evento_id = $evento->id;
            $localretirada_evento->localretirada_id = $localretirada->id;
            $localretirada_evento->save();

        }

        if($request->locais != NULL){
            foreach($request->locais as $local){
                $localretirada_evento = new \projetoGCA\LocalRetiradaEvento();
                $localretirada_evento->evento_id = $evento->id;
                $localretirada_evento->localretirada_id = $local;
                $localretirada_evento->save();
            }
        }

        return redirect("/evento/produtores/".$grupoConsumo->id);

    }

    public function listar($idGrupoConsumo){
        if(Auth::check()){


            $grupoConsumo = \projetoGCA\GrupoConsumo::where('id','=',$idGrupoConsumo)->first();
            $eventos = \projetoGCA\Evento::where('grupoconsumo_id', '=', $idGrupoConsumo)->orderBy('data_evento', 'desc')->get();
            $ultimoEvento = \projetoGCA\Evento::where('grupoconsumo_id', '=', $grupoConsumo->id)->where('estaAberto', '=' ,'True')->first();
            return view("evento.eventos", [
              'eventos' => $eventos,
              'grupoConsumo' => $grupoConsumo,
              'ultimoEvento' => $ultimoEvento,
              ]);
        }
        return view("/home");
    }

    public function pedidos($evento_id){
        $evento = \projetoGCA\Evento::find($evento_id);
        $grupoConsumo = \projetoGCA\GrupoConsumo::where('id','=',$evento->grupoconsumo_id)->first();
        $pedidos = \projetoGCA\Pedido::where('evento_id','=',$evento->id)->get();

        return view("pedido.pedidos", ['pedidos' => $pedidos,
                                       'evento' => $evento,
                                       'grupoConsumo' => $grupoConsumo]);
    }

    public function tipoPedido($pedido_id){

      $pedido = \projetoGCA\Pedido::find($pedido_id);
      $evento = \projetoGCA\Evento::find($pedido->evento_id);
      $grupoConsumo = \projetoGCA\GrupoConsumo::find($evento->grupoconsumo_id);

      return view("pedido.tipoPedido", [ 'pedido' => $pedido,
                                         'evento' => $evento,
                                         'grupoConsumo' => $grupoConsumo]);
    }

    public function itensPedido($pedido_id){

        $pedido = \projetoGCA\Pedido::find($pedido_id);
        $evento = \projetoGCA\Evento::find($pedido->evento_id);
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($evento->grupoconsumo_id);

        return view("pedido.itensPedido", ['itensPedido' => $pedido->itens,
                                           'evento' => $evento,
                                           'grupoConsumo' => $grupoConsumo]);
    }

    public function fecharEvento($eventoId){
        $evento = \projetoGCA\Evento::find($eventoId);
        $evento->estaAberto = False;
        $evento->update();
        return back()->with('success','Evento '.$evento->id.' fechado.');
    }

    public function listarProdutores($idGrupoConsumo){

      $grupoConsumo = \projetoGCA\GrupoConsumo::find($idGrupoConsumo);

      $produtores = \projetoGCA\Produtor::where('grupoconsumo_id','=',$idGrupoConsumo)->orderBy('nome')->get();

      $produtos = \projetoGCA\Produto::where('grupoconsumo_id', '=', $idGrupoConsumo)->get();

      foreach ($produtores as $produtor) {
        $produtor->ativo = True;
        $produtor->update();
      }

      foreach ($produtos as $produto) {
        $produto->ativo = True;
        $produto->update();
      }

      return view("evento.produtores", ['produtores' => $produtores,
                                        'grupoConsumo' => $grupoConsumo]);
    }

    public function desativarProdutores(Request $request){
      $input = $request->input();

      $produtores = \projetoGCA\Produtor::where('grupoconsumo_id','=',$input['idGrupoConsumo'])->get()->toArray();

      foreach ($produtores as $produtor) {
        if(!in_array($produtor['id'], $input['checkbox'])){
          $produtor = \projetoGCA\Produtor::find($produtor['id']);
          $produtor->ativo = False;
          $produtor->update();

          $produtos = \projetoGCA\Produto::where('produtor_id', '=', $produtor->id)->get();

          foreach ($produtos as $produto) {
            $produto->ativo = False;
            $produto->update();
          }
        }
      }

      return redirect("/evento/produtos/".$input['idGrupoConsumo']);
    }

    public function listarProdutos($idGrupoConsumo){

      $grupoConsumo = \projetoGCA\GrupoConsumo::find($idGrupoConsumo);

      $produtoresDesativados = \projetoGCA\Produtor::where('grupoconsumo_id', '=', $idGrupoConsumo)
                                       ->where('ativo', '=', False)->get();

      $produtos = \projetoGCA\Produto::where('grupoconsumo_id', '=', $idGrupoConsumo)->orderBy('nome')->get();

      foreach ($produtoresDesativados as $produtor) {
        foreach ($produtos as $key => $produto) {
          if($produtor->id == $produto->produtor_id) {
            unset($produtos[$key]);
          }
        }
      }

      return view("evento.produtos", ['produtos' => $produtos,
                                      'grupoConsumo' => $grupoConsumo]);
    }

    public function editarProdutos($idGrupoConsumo){

      $grupoConsumo = \projetoGCA\GrupoConsumo::find($idGrupoConsumo);

      $produtoresDesativados = \projetoGCA\Produtor::where('grupoconsumo_id', '=', $idGrupoConsumo)
                                       ->where('ativo', '=', False)->get();

      $produtos = \projetoGCA\Produto::where('grupoconsumo_id', '=', $idGrupoConsumo)->orderBy('nome')->get();

      foreach ($produtoresDesativados as $produtor) {
        foreach ($produtos as $key => $produto) {
          if($produtor->id == $produto->produtor_id) {
            unset($produtos[$key]);
          }
        }
      }

      return view("evento.editarProduto", ['produtos' => $produtos,
                                      'grupoConsumo' => $grupoConsumo]);
    }

    public function desativarProdutos(Request $request){
      $input = $request->input();
      //dd($input);
      
      if(!(isset($input["checkbox"]))){
        return redirect()->back()->with('fail','Selecione um ou mais produtos');
      }

      $produtos= \projetoGCA\Produto::where('grupoconsumo_id','=',$input['idGrupoConsumo'])->get();
                                                        // ->where('ativo','=',True)->get();

      
      foreach ($produtos as $produto) {
        if(!in_array($produto['id'], $input['checkbox'])){
          $produto = \projetoGCA\Produto::find($produto['id']);
          $produto->ativo = False;
          $produto->update();
        }else{
          $produto->ativo = True;
          $produto->update();
        }
      }

      return redirect()
              ->action('EventoController@listar', $request->idGrupoConsumo)
              ->withInput();
    }

}
