<?php

namespace projetoGCA\Http\Controllers;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \projetoGCA\GrupoConsumo;
use \projetoGCA\Evento;
use \projetoGCA\Produto;
use \projetoGCA\Produtor;

class LojaController extends Controller
{
  public function gruposConsumoUsuario(){
      $consumidores = Auth::user()->consumidores;

      $subset = $consumidores->map(function ($consumidor) {
          return collect($consumidor->toArray())
               ->only(['grupo_consumo_id'])
               ->all();
      });

      $gruposConsumo = GrupoConsumo::whereIn('id', $subset)->get();

      return view("loja.lojaEventos", ['gruposConsumo' => $gruposConsumo]);
  }

  public static function buscarEventosDeGrupodeConsumo($idGrupoConsumo){

      $eventos = Evento::where('grupoconsumo_id', '=', $idGrupoConsumo)
                              ->where('data_evento', '>', new DateTime())
                              // ->where('data_fim_pedidos', '>=', new DateTime())
                              ->where('estaAberto','=','true')->get();
                              // ->orderBy('data_evento', 'ASC')

      return $eventos;
  }

  public function produtosEvento($idEvento){

      $evento = Evento::find($idEvento);
      $grupoConsumo = GrupoConsumo::find($evento->grupoconsumo_id);

      $produtoresDesativados = Produtor::where('grupoconsumo_id', '=', $evento->grupoconsumo_id)
                                       ->where('ativo', '=', False)->get();

      $produtos = Produto::where('grupoconsumo_id', '=', $evento->grupoconsumo_id)
                         ->where('ativo', '=', True)
                         ->orderBy('nome')->get();

      return view("loja.lojaProdutos", ['grupoConsumo' => $grupoConsumo,
                                        'evento' => $evento,
                                        'produtos' => $produtos,
                                        ]);
  }


}
