<?php

namespace projetoGCA\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateInterval;
use Illuminate\Http\Request;

class EventoController extends Controller
{

    public function novo($idGrupoConsumo){
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($idGrupoConsumo);
        return view('evento.adicionarEvento', [ 'grupoConsumo' => $grupoConsumo ]);
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

        $dataHoje = new DateTime();
        $grupoConsumo = \projetoGCA\GrupoConsumo::find($request->id_grupo_consumo);

        $ultimoEvento = \projetoGCA\Evento::where('grupoconsumo_id', '=', $grupoConsumo->id)->orderBy('id', 'DESC')->first();
        // return var_dump(empty($ultimoEvento));

        $dataEvento = new DateTime($request->data_evento);
        $dataAtual = new DateTime();
        //return gettype($dataAtual);
        if($dataEvento < $dataAtual){
            return back()->withErrors(['data_evento' => 'Data do envento não pode ser anterior à data atual']);
        }

        if(!is_null($ultimoEvento)){
            $dataUltimoEvento = new DateTime($ultimoEvento->data_evento);
            if($dataHoje < $dataUltimoEvento){
                return redirect()
                        ->action('EventoController@listar', $grupoConsumo->id)
                        ->with('warning', 'Existem eventos ainda não realizados.');
            }
            if($dataAtual > new DateTime($evento->data_evento)){
                return redirect()
                        ->action('EventoController@listar', $grupoConsumo->id)
                        ->with('warning', 'A data do evento não pode ser anterior a data atual.');
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

        return redirect()
                ->action('EventoController@listar', $request->id_grupo_consumo)
                ->withInput();
    }

    public function listar($idGrupoConsumo){
        if(Auth::check()){
            $grupoConsumo = \projetoGCA\GrupoConsumo::where('id','=',$idGrupoConsumo)->first();
            $eventos = \projetoGCA\Evento::where('grupoconsumo_id', '=', $idGrupoConsumo)->get();
            return view("evento.eventos", ['eventos' => $eventos], ['grupoConsumo' => $grupoConsumo]);
        }
        return view("/home");
    }

    public function pedidos($evento_id){
        $evento = \projetoGCA\Evento::find($evento_id);
        $grupoConsumo = \projetoGCA\GrupoConsumo::where('id','=',$evento->grupoconsumo_id)->first();
        $pedidos = \projetoGCA\Pedido::where('evento_id','=',$evento_id)->get();
        $totaisItens = array();
        $totaisPedidos = array();
        foreach($pedidos as $pedido){
            $itens = $pedido->itens;
            array_push($totaisItens, count($itens));
            $total = 0;
            foreach($itens as $item){
                $total += $item->preco * $item->quantidades;
            }
            array_push($totaisPedidos, $total);
        }

        return view("pedido.pedidos", ['pedidos' => $pedidos, 'evento' => $evento, 'grupoConsumo' => $grupoConsumo, 'totaisItens' => $totaisItens, 'totaisPedidos' => $totaisPedidos, 'evento_id'=>$evento_id]);
    }

    public function itensPedido($pedido_id){
        $pedido = \projetoGCA\Pedido::find($pedido_id);
        return view("pedido.itensPedido", ['itensPedido' => $pedido->itens]);
    }

    public function fecharEvento($eventoId){
        $evento = \projetoGCA\Evento::find($eventoId);
        $evento->estaAberto = False;
        $evento->update();
        return back()->with('success','Evento '.$evento->id.' fechado.');
    }

}
