<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('CadastroUsuario');
// });


Route::get('/erroUsuarioExistente', function () {
    return "<h1> Usuário Existente </h1>";
});
// Rotas para Contatos
Route::get('/adicionarContato', 'ContatoController@novo');
Route::post('/cadastrarContato', 'ContatoController@cadastrar');

Route::get('/listarUsuarios', 'UserController@listar');
Route::get('/cadastrarUsuario', 'UserController@cadastrar');
Route::get('/editarUsuario/{id}', 'UserController@editar');
Route::post('/adicionarUsuario', 'UserController@adicionar');
Route::post('/salvarUsuario', 'UserController@salvar');

// Rotas para Unidade de Vendas
Route::get('/unidadesVenda', "UnidadeVendaController@listar");
Route::get('/adicionarUnidadeVenda', "UnidadeVendaController@adicionar");
Route::get('/editarUnidadeVenda/{id}', "UnidadeVendaController@editar");
Route::get('/removerUnidadeVenda/{id}', "UnidadeVendaController@remover");
Route::post('/cadastrarUnidadeVenda', "UnidadeVendaController@cadastrar");
Route::post('/atualizarUnidadeVenda', "UnidadeVendaController@atualizar");

Route::get('/erroCadastroExiste', function () {
    return "<h1>Não foi possível realizar o cadastro, já existe um registro com este nome.</h1>";
});

// Rotas para Produtos
Route::post('/cadastrarProduto', 'ProdutoController@cadastrar');
Route::get('/editarProduto/{idGrupoConsumo}', 'ProdutoController@editar');
Route::get('/removerProduto/{idGrupoConsumo}', 'ProdutoController@remover');
Route::get('/adicionarProduto/{idGrupoConsumo}',  'ProdutoController@novo');
Route::get('/removerProduto/{idGrupoConsumo}',  'ProdutoController@remover');
Route::post('/atualizarProduto', "ProdutoController@atualizar");
Route::get('/produtos/{idGrupoConsumo}', 'ProdutoController@listar');

// Rotas para Consumidor
Route::post('/cadastrarConsumidor', 'ConsumidorController@cadastrar');
Route::get('/adicionarConsumidor',  'ConsumidorController@adicionar');
Route::get('/consumidores/{idGrupoConsumo}', 'ConsumidorController@listar');
Route::get('/selecionarGrupo', 'ConsumidorController@selecionarGrupo');
Route::get('/meusPedidos', 'ConsumidorController@pedidos');

// Rotas para Grupo de Consumo
Route::post('/cadastrarGrupoConsumo', 'GrupoConsumoController@cadastrar');
Route::get('/editarGrupoConsumo/{id}', 'GrupoConsumoController@editar');
Route::get('/adicionarGrupoConsumo',  'GrupoConsumoController@novo');
Route::get('/gerenciar/{id}', 'GrupoConsumoController@gerenciar');
Route::post('/atualizarGrupoConsumo', "GrupoConsumoController@atualizar");
Route::post('/salvarGrupoConsumo',  'GrupoConsumoController@salvar');
Route::get('/gruposConsumo', 'GrupoConsumoController@listar');

// Rotas para Eventos
Route::post('/cadastrarEvento', 'EventoController@cadastrar');
Route::get('/editarEvento/{idGrupoConsumo}', 'EventoController@editar');
Route::get('/adicionarEvento/{idGrupoConsumo}',  'EventoController@novo');
Route::post('/salvarEvento',  'EventoController@salvar');
Route::get('/eventos/{idGrupoConsumo}', 'EventoController@listar');
Route::get('/evento/pedidos/{evento_id}', 'EventoController@pedidos');
Route::get('/evento/pedidos/itens/{pedido_id}', 'EventoController@itensPedido');
Auth::routes();

// Rotas para Loja
Route::get('/loja', 'PedidoController@loja');

// Rotas para Carrinho
Route::post('/carrinho', 'PedidoController@confirmar');
Route::post('/pedidoFinalizado', 'PedidoController@finalizar');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function(){
    return redirect()->action('HomeController@index');
});

// Rotas para relatorios
Route::get('/evento/pedidos/relatorioProdutor/{evento_id}', 'PdfController@criarRelatorioPedidosProdutores');
Route::get('/evento/pedidos/relatorioComposicao/{evento_id}', 'PdfController@criarRelatorioComposicaoPedidos');

