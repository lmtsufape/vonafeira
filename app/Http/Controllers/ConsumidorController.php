<?php

namespace projetoGCA\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use \projetoGCA\Consumidor;
use \projetoGCA\Pedido;
use \projetoGCA\ItemPedido;
use \projetoGCA\User;
use \projetoGCA\Evento;
use \projetoGCA\GrupoConsumo;
use Illuminate\Support\Facades\Hash;
use projetoGCA\Endereco;

class ConsumidorController extends Controller
{
    /**
     * @Deprecated
     */
    public function adicionar(){
        $user = User::all();
        $grupoConsumo = GrupoConsumo::all();
        return view("consumidor.adicionarConsumidor", ['users' => $user], ['gruposConsumo' => $grupoConsumo]);
    }

    public function cadastrar($grupoConsumoid){

        $query = Consumidor::where([
                          ['grupo_consumo_id', '=', $grupoConsumoid],
                          ['user_id', '=', Auth::user()->id]
                        ])->first();

        if(is_null($query)){
          $consumidor = new Consumidor();
          $consumidor->user_id = Auth::user()->id;
          $consumidor->grupo_consumo_id = $grupoConsumoid;
          $consumidor->save();
        }

        $grupoConsumo = GrupoConsumo::find($grupoConsumoid);

        return redirect("/home")->with('success','Você agora está participando do grupo: '.$grupoConsumo->name);

    }

    public static function cadastrarCoordenador($idGrupoConsumo, $idCoordenador){

        $query = Consumidor::where([
                          ['grupo_consumo_id', '=', $idGrupoConsumo],
                          ['user_id', '=', $idCoordenador]
                        ])->first();

        if(is_null($query)){
          $consumidor = new Consumidor();
          $consumidor->user_id = $idCoordenador;
          $consumidor->grupo_consumo_id = $idGrupoConsumo;
          $consumidor->save();
        }
    }

    public function listar($idGrupoConsumo){
        if(Auth::check()){
            $grupoConsumo = GrupoConsumo::find($idGrupoConsumo);
            $consumidores = Consumidor::where('grupo_consumo_id', '=', $idGrupoConsumo)->get();
            $users_id = array();
            foreach($consumidores as $consumidor){
                array_push($users_id,$consumidor->user_id);
            }
            $consumidores = User::whereIn('id',$users_id)->orderBy('name')->get();
            return view(
                "consumidor.consumidores",
                ['consumidores' => $consumidores,
                'grupoConsumo' => $grupoConsumo]
            );
        }
        return view("/home");
    }

    public function buscarGrupo(){

      return view('consumidor.entrarGrupo', ['gruposConsumo' => [],
                                             'termo' => [] ]);
    }

    public function pedidos(){
      $consumidores = Auth::user()->consumidores;

      $subset = $consumidores->map(function ($consumidor) {
          return collect($consumidor->toArray())
               ->only(['id'])
               ->all();
      });

      $pedidos = Pedido::whereIn('consumidor_id', $subset)
                       ->orderBy('id', 'DESC')->get();

      return view('consumidor.meusPedidos', ['pedidos'=>$pedidos]);
    }

    public function itensPedido($pedido_id){

        $pedido = \projetoGCA\Pedido::find($pedido_id);
        $itens = $pedido->itens;

        return view('consumidor.meusItensPedido', ['itensPedido' => $itens]);
    }


    public function editarPedido($idPedido){
      $pedido = Pedido::find($idPedido);
      $evento = Evento::find($pedido->evento_id);
      $itensPedido = ItemPedido::where('pedido_id','=',$pedido->id)->get();

      return view("consumidor.editarPedido", [
          'pedido' => $pedido,
          'evento' => $evento,
          'itensPedido' => $itensPedido]
      );
    }

    public function removerPedido($idItemPedido){

      $itemPedido = \projetoGCA\ItemPedido::find($idItemPedido);
      $pedido = Pedido::where('id','=',$itemPedido->pedido_id)->first();

      $itemPedido->delete();

      $evento = Evento::find($pedido->evento_id);
      $itensPedido = ItemPedido::where('pedido_id','=',$pedido->id)->get();

      if(count($itensPedido) == 0){
        $pedido->delete();
        return redirect("/meusPedidos");
      }else{
        return redirect("/editarPedido/$pedido->id");
      }

    }

    public function atualizarPedido(Request $request){
      $input = $request->input();
      $array_of_item_ids = $input['item_id'];
      $quantidades = $input['quantidade'];

      $itensPedido = ItemPedido::whereIn('id', $array_of_item_ids)->get();

      $i = 0;

      foreach ($itensPedido as $item){
          if($quantidades[$i] > 0){
              $item->quantidade = $quantidades[$i];
              $item->update();
          }
          $i = $i + 1;
      }

      return redirect("/meusPedidos");
    }

    public function cancelarPedido($idPedido) {
        $pedido = \projetoGCA\Pedido::find($idPedido);

        $itens = \projetoGCA\ItemPedido::where('pedido_id','=',$idPedido)->get();

        foreach ($itens as $item) {
          $item->delete();
        }

        $pedido->delete();

        return back()
                ->withInput();
    }

    public function editarCadastro() {
      return view('consumidor.editarCadastro',['user' => (\Auth::user())]);
    }

    public function atualizarCadastro(Request $request){
      $usuario = \Auth::user();

      if($request->email != $usuario->email){
        $validator = Validator::make($request->all(), [
          'email' => 'unique:users|email'
        ]);

        if($validator->fails()){
          return redirect()->back()->withErrors($validator->errors())->withInput();
        }
      }

      $validator = Validator::make($request->all(),[
        'name' => 'required',
        'telefone' => 'required|min:10'
      ]);

      if($validator->fails()){
        return redirect()->back()->withErrors($validator->errors())->withInput();
      }  

      if (!(Hash::check($request->senha, $usuario->password))){
        $validator = Validator::make([],[]);
        $validator->errors()->add('senha', 'Senha incorreta.');;
        return redirect()->back()->withErrors($validator->errors())->withInput();
      }

      $usuario->name = $request->name;
      $usuario->email = $request->email;
      $usuario->telefone = $request->telefone;

      // endereço
      if($request->cep != null){
        $endereco = new Endereco();
        $endereco->rua = $request['rua'];
        $endereco->numero = $request['numero'];
        $endereco->bairro = $request['bairro'];
        $endereco->cidade = $request['cidade'];
        $endereco->uf = $request['uf'];
        $endereco->cep = $request['cep'];
        $endereco->save();
       
        $usuario->endereco()->associate($endereco);
      }

      $usuario->save();

      return redirect()->back()->with('success','Dados cadastrais salvos.');
    }

    public function alterarSenha(){
      return view('consumidor.alterarSenha');
    }

    public function atualizarSenha(Request $request){
      $usuario = \Auth::user();

      if (!(Hash::check($request->senha_atual, $usuario->password))){
        return redirect()->back()->with('fail','Senha atual incorreta.');
      }

      if ($request->nova_senha != $request->nova_senha_confirm){
        return redirect()->back()->with('fail','Nova senha e confirmação são diferentes.');
      }

      $validator = Validator::make($request->all(), [
        'nova_senha' => 'min:6|max:16'
      ]);

      if($validator->fails()){
        return redirect()->back()->withErrors($validator->errors())->withInput();
      }

      $usuario->password = bcrypt($request->nova_senha);
      $usuario->save();

      return redirect()->back()->with('success','Senha alterada com sucesso!');
    }
}
