<?php

namespace projetoGCA\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use \projetoGCA\Consumidor;
use \projetoGCA\Pedido;
use \projetoGCA\ItemPedido;
use \projetoGCA\Produto;
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
     
      $itensPedido = itemPedido::where('pedido_id','=',$pedido->id)->join('produtos', 'item_pedidos.produto_id', '=', 'produtos.id')->orderBy('produtos.nome')->select('item_pedidos.*')->get();
    
      $grupoConsumo = GrupoConsumo::find($evento->grupoconsumo_id);
      $produtos = Produto::where('grupoconsumo_id', '=', $evento->grupoconsumo_id)
                         ->where('ativo', '=', True)
                         ->orderBy('nome')->get();
     
      $produtos_ids = [];
      foreach($itensPedido as $item){
        array_push($produtos_ids, $item->produto_id);
      }
   
      foreach($produtos as $produto){
        array_push($produtos_ids, $produto->id);
      }
  
      $produtos_ids = array_unique($produtos_ids);      
      $produtos = Produto::whereIn('id',$produtos_ids)->orderBy('nome')->get();
      
      return view("consumidor.editarPedido", [
          'pedido' => $pedido,
          'evento' => $evento,
          'itensPedido' => $itensPedido,
          'grupoConsumo' => $grupoConsumo,
          'produtos' => $produtos]
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
      if(!(array_key_exists("checkbox",$input))){
        return redirect()->back()->with('fail','Necessária a seleção de um ou mais itens.');
      }
      
      //itens que faziam parte do pedido original
      $array_of_item_ids = $input['item_id'];      
      $itensPedido = ItemPedido::whereIn('id', $array_of_item_ids)->get();
     
      //no formato: $quantidades[id_produto_selecionado] = quantidade
      $checkboxes = $input['checkbox'];
      $keys_checkbox = array_keys($checkboxes);
      $quantidades = $input['quantidade'];
      $keys_quantidades = array_keys($quantidades);

      $array_of_product_ids = array_intersect($keys_quantidades, $keys_checkbox);
      
      foreach($itensPedido as $item){        
        if( ($key = array_search($item->produto_id, $array_of_product_ids)) !== false ){
          if( $item->quantidade != $quantidades[$item->produto_id] && $quantidades[$item->produto_id] > 0){
            //se os produtos adicionados já existiam no pedido original => atualizar
            $item->quantidade = $quantidades[$item->produto_id];
            $item->update();
          }            
          unset($array_of_product_ids[$key]);
        }else if(!in_array($item->produto_id, $array_of_product_ids)){
          //se existem produtos que existiam no pedido original e não existem mais => remover
          $item->delete();
        }
      }
      
      //se os produtos adicionados não existiam no pedido original => adicionar
      $produtos = Produto::whereIn('id', $array_of_product_ids)->get();
      foreach($produtos as $produto){
        if($quantidades[$produto->id] > 0){
          $item = new ItemPedido();
          $item->pedido_id = $input['pedido_id'];
          $item->produto_id = $produto->id;
          $item->quantidade = $quantidades[$produto->id];
          $item->save();
        }
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
          'email' => 'required|string|email|max:255|unique:users'
        ]);

        if($validator->fails()){
          return redirect()->back()->withErrors($validator->errors())->withInput();
        }
      }

      $validator = Validator::make($request->all(),[
        'name' => 'required|string|max:255|regex:/^\s*\S+(?:\s+\S+){1,}$/|regex:/^[\pL\s\-\á\Á\é\É\í\Í\ó\Ó\ú\Ú\ã\Ã\õ\Õ\â\Â\ê\Ê\î\Î\ô\Ô\û\Û\']+$/',
        'telefone' => 'required|regex:/^\(\d{2}\)\s\d{4,5}-\d{4}$/',
        
        'cep'=> 'required_with:rua,bairro,cidade,uf',
        'rua' => 'required_with:cep,bairro,cidade,uf',
        'bairro' => 'required_with:cep,rua,cidade,uf',
        'cidade' => 'required_with:cep,rua,bairro,uf',
        'uf' => 'required_with:cep,rua,bairro,cidade',
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

      $usuario->save();

      if($request->cep != null){
        $endereco = $usuario->endereco == null ? new Endereco() : $usuario->endereco;
        
        $endereco->rua = $request['rua'];
        $endereco->numero = $request['numero'];
        $endereco->bairro = $request['bairro'];
        $endereco->cidade = $request['cidade'];
        $endereco->uf = $request['uf'];
        $endereco->cep = $request['cep'];
       
        if($usuario->endereco == null){
          $usuario->endereco()->save($endereco);
        }else{
          $endereco->save();
        }
        
      }
 
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

    public function escreverEmail(Request $request, $grupoConsumoId){
      
      if(!(isset($request["checkbox"]))){
        return redirect()->back()->with('fail','Selecione um ou mais consumidores');
      }

      $destinatarios_id = array_keys($request["checkbox"]);
      $grupoConsumo = GrupoConsumo::find($grupoConsumoId);
      
      $destinatarios = User::whereIn('id',$destinatarios_id)->orderBy('name')->get();
      
      
      return view('consumidor.escreverEmail',
                ['destinatarios' => $destinatarios,
                'grupoConsumo' => $grupoConsumo]
      );
    }
}
