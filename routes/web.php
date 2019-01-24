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

Auth::routes();

//Rota para termo de uso
Route::get('/termos','PdfController@termosDeUso');

Route::get('/compartilhar/{grupoConsumoId}', 'GrupoConsumoController@compartilhar')->middleware('auth');

Route::middleware('autorizacao')->group(function() {

    // Rotas para Unidade de Vendas
    Route::get('/unidadesVenda/{grupoConsumoId}', "UnidadeVendaController@listar");
    Route::get('/adicionarUnidadeVenda/{grupoConsumoId}', "UnidadeVendaController@adicionar");
    Route::get('/editarUnidadeVenda/{grupoConsumoId}/{id}', "UnidadeVendaController@editar");
    Route::get('/removerUnidadeVenda/{id}', "UnidadeVendaController@remover");
    Route::post('/cadastrarUnidadeVenda', "UnidadeVendaController@cadastrar");
    Route::post('/atualizarUnidadeVenda', "UnidadeVendaController@atualizar");

    Route::get('/erroCadastroExiste', function () {
        return "<h1>Não foi possível realizar o cadastro, já existe um registro com este nome.</h1>";
    });

    // Rotas para Produtos
    Route::post('/cadastrarProduto', 'ProdutoController@cadastrar');
    Route::get('/editarProduto/{idProduto}', 'ProdutoController@editar');  //todo
    Route::get('/removerProduto/{idProduto}', 'ProdutoController@remover');
    Route::get('/adicionarProduto/{idGrupoConsumo}',  'ProdutoController@novo');
    Route::post('/atualizarProduto', "ProdutoController@atualizar");
    Route::get('/produtos/{idGrupoConsumo}', 'ProdutoController@listar');

    // Rotas para Produtores
    Route::post('/cadastrarProdutor', 'ProdutorController@cadastrar');
    Route::get('/editarProdutor/{idProdutor}', 'ProdutorController@editar');
    Route::get('/removerProdutor/{idProdutor}', 'ProdutorController@remover');
    Route::get('/adicionarProdutor/{idGrupoConsumo}',  'ProdutorController@novo');
    Route::post('/atualizarProdutor', "ProdutorController@atualizar");
    Route::get('/produtores/{idGrupoConsumo}', 'ProdutorController@listar');

    // Rotas para Consumidor
    Route::post('/cadastrarConsumidor', 'ConsumidorController@cadastrar');
    Route::get('/adicionarConsumidor',  'ConsumidorController@adicionar');
    Route::get('/consumidores/{idGrupoConsumo}', 'ConsumidorController@listar');
    Route::get('/selecionarGrupo', 'ConsumidorController@selecionarGrupo');
    Route::get('/meusPedidos', 'ConsumidorController@pedidos');
    Route::get('/meusPedidos/{pedido_id}', 'ConsumidorController@itensPedido');
    Route::get('/editarPedido/{id}','ConsumidorController@editarPedido');
    Route::get('/cancelarPedido/{id}', "ConsumidorController@cancelarPedido");
    Route::post('/atualizarPedido', "ConsumidorController@atualizarPedido");
    Route::get('/removerProdutoPedido/{idItemPedido}','ConsumidorController@removerPedido');

    // Rotas para Grupo de Consumo
    Route::post('/cadastrarGrupoConsumo', 'GrupoConsumoController@cadastrar');
    Route::get('/editarGrupoConsumo/{id}', 'GrupoConsumoController@editar');
    Route::get('/adicionarGrupoConsumo',  'GrupoConsumoController@novo');
    Route::get('/gerenciar/{id}', 'GrupoConsumoController@gerenciar');
    Route::post('/atualizarGrupoConsumo', "GrupoConsumoController@atualizar");
    Route::post('/salvarGrupoConsumo',  'GrupoConsumoController@salvar');
    Route::get('/gruposConsumo', 'GrupoConsumoController@listar');
    Route::get('/grupoconsumo/sair/{grupoConsumoId}', 'GrupoConsumoController@sair');

    // Rotas para Eventos
    Route::post('/cadastrarEvento', 'EventoController@cadastrar');
    Route::get('/editarEvento/{idGrupoConsumo}', 'EventoController@editar');
    Route::get('/adicionarEvento/{idGrupoConsumo}',  'EventoController@novo');
    Route::post('/salvarEvento',  'EventoController@salvar');
    Route::get('/eventos/{idGrupoConsumo}', 'EventoController@listar');
    Route::get('/evento/pedidos/{evento_id}', 'EventoController@pedidos');
    Route::get('/evento/pedidos/itens/{pedido_id}', 'EventoController@itensPedido');
    Route::get('/evento/fechar/{eventoId}', 'EventoController@fecharEvento');

    // Rotas para Loja
    Route::get('/loja', 'LojaController@gruposConsumoUsuario');
    Route::get('/loja/evento/{id}','LojaController@produtosEvento');

    // Rotas para Carrinho
    Route::post('/carrinho', 'PedidoController@confirmar');
    Route::post('/pedidoFinalizado', 'PedidoController@finalizar');

    Route::get('/visualizarPedido/{id}','PedidoController@visualizar');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/', function(){
        return redirect()->action('HomeController@index');
    });

    // Rotas para relatorios
    Route::get('/evento/pedidos/relatorioProdutor/{evento_id}', 'PdfController@criarRelatorioPedidosProdutores');
    Route::get('/evento/pedidos/relatorioConsumidor/{evento_id}', 'PdfController@criarRelatorioPedidosConsumidores');
    Route::get('/evento/pedidos/relatorioComposicao/{evento_id}', 'PdfController@criarRelatorioMontagemPedidos');

    //Rotas para emails
    Route::post('/share/mail','MyMailController@emailCompartilhar');
});
