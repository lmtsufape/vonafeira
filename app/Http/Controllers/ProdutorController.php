<?php

namespace projetoGCA\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdutorController extends Controller
{
  public function novo($idGrupoConsumo){
      $grupoConsumo = \projetoGCA\GrupoConsumo::where('id','=',$idGrupoConsumo)->first();
      return view("produtor.adicionarProdutor", ['grupoConsumo' => $grupoConsumo]);
  }

  public function listar($idGrupoConsumo){
      if(\Auth::check()){
          $grupoConsumo = \projetoGCA\GrupoConsumo::where('id','=',$idGrupoConsumo)->first();

          $produtores = \projetoGCA\Produtor::where('grupoconsumo_id','=',$idGrupoConsumo)->get();

          return view("produtor.produtores", ['produtores' => $produtores, 'grupoConsumo' => $grupoConsumo]);
      }
      return view("/home");
  }

  public function cadastrar(Request $request){
      $validator = Validator::make($request->all(), [
          'nome' => 'required|min:3|max:191',
          'endereco' => 'required|min:4|max:191',
      ]);

      if($validator->fails()){
          return redirect()->back()->withErrors($validator->errors())->withInput();
      }

      $produtor = new \projetoGCA\Produtor();
      $produtor->grupoconsumo_id = $request->grupoConsumo;
      $produtor->nome = $request->nome;
      $produtor->endereco = $request->endereco;
      $produtor->telefone = $request->telefone;
      $produtor->save();
      return redirect()
              ->action('ProdutorController@listar', $request->grupoConsumo)
              ->withInput();

  }

  public function editar($id) {
      $produtor = \projetoGCA\Produtor::find($id);
      $grupoConsumo = \projetoGCA\GrupoConsumo::where('id','=',$produtor->grupoconsumo_id)->first();

      return view(
          "produtor.editarProdutor",
          ['grupoConsumo' => $grupoConsumo,
          'produtor' => $produtor]
      );
  }

  public function remover($id) {
      $produtor = \projetoGCA\Produtor::find($id);

      $produtos = \projetoGCA\Produto::where('produtor_id','=',$produtor->id)->get();

      foreach ($produtos as $produto) {
        $produto->delete();
      }

      $produtor->delete();

      $grupoConsumo = $produtor->grupoconsumo_id;


      return redirect()
              ->action('ProdutorController@listar', $grupoConsumo)
              ->withInput();
  }

  public function atualizar(Request $request){
      $produtor = \projetoGCA\Produtor::find($request->id);

      $produtor->nome = $request->nome;
      $produtor->endereco = $request->endereco;
      $produtor->telefone = $request->telefone;
      $produtor->update();

      return redirect()
              ->action('ProdutorController@listar', $request->grupoConsumo)
              ->withInput();
  }
}
