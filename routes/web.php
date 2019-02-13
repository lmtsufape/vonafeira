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


Auth::routes();

//Rota para termo de uso
Route::get('/termos','PdfController@termosDeUso')->name('termos');

Route::get('/compartilhar/{grupoConsumoId}', 'GrupoConsumoController@compartilhar')->name('compartilhar.get')->middleware('auth');

Route::middleware('autorizacao')->group(function() {

    // Rotas para Unidade de Vendas
    Route::get('/adicionarUnidadeVenda/{grupoConsumoId}', "UnidadeVendaController@adicionar")->name('unidadeVenda.novo');
    Route::get('/editarUnidadeVenda/{grupoConsumoId}/{id}', "UnidadeVendaController@editar")->name('unidadeVenda.editar');
    Route::get('/unidadesVenda/{grupoConsumoId}', "UnidadeVendaController@listar")->name('unidadeVenda.listar');
    Route::get('/removerUnidadeVenda/{id}', "UnidadeVendaController@remover")->name('unidadeVenda.remover');
    Route::post('/cadastrarUnidadeVenda', "UnidadeVendaController@cadastrar")->name('unidadeVenda.cadastrar');
    Route::post('/atualizarUnidadeVenda', "UnidadeVendaController@atualizar")->name('unidadeVenda.atualizar');

    // Rotas para Produtos
    Route::get('/adicionarProduto/{idGrupoConsumo}',  'ProdutoController@novo')->name('produto.novo');
    Route::get('/editarProduto/{idProduto}', 'ProdutoController@editar')->name('produto.editar');
    Route::get('/produtos/{idGrupoConsumo}', 'ProdutoController@listar')->name('produto.listar');
    Route::get('/removerProduto/{idProduto}', 'ProdutoController@remover')->name('produto.remover');
    Route::post('/cadastrarProduto', 'ProdutoController@cadastrar')->name('produto.cadastrar');
    Route::post('/atualizarProduto', "ProdutoController@atualizar")->name('produto.atualizar');

    // Rotas para Produtores
    Route::get('/adicionarProdutor/{idGrupoConsumo}',  'ProdutorController@novo')->name('produtor.novo');
    Route::get('/editarProdutor/{idProdutor}', 'ProdutorController@editar')->name('produtor.editar');
    Route::get('/produtores/{idGrupoConsumo}', 'ProdutorController@listar')->name('produtor.listar');
    Route::get('/removerProdutor/{idProdutor}', 'ProdutorController@remover')->name('produtor.remover');
    Route::post('/cadastrarProdutor', 'ProdutorController@cadastrar')->name('produtor.cadastrar');
    Route::post('/atualizarProdutor', "ProdutorController@atualizar")->name('produtor.atualizar');

    // Rotas para Consumidor
    Route::get('/consumidores/{idGrupoConsumo}', 'ConsumidorController@listar')->name('consumidor.listar');
    Route::get('/entrarGrupo', 'ConsumidorController@entrarGrupo')->name('consumidor.grupo.entrar');
    Route::post('/cadastrarConsumidor', 'ConsumidorController@cadastrar')->name('consumidor.cadastrar');
    Route::get('/editarCadastro', 'ConsumidorController@editarCadastro')->name('consumidor.editarCadastro');
    Route::post('/atualizarCadastro', 'ConsumidorController@atualizarCadastro')->name('consumidor.cadastro.atualizar');
    Route::get('/alterarSenha', 'ConsumidorController@alterarSenha')->name('consumidor.alterarSenha');
    Route::post('/atualizarSenha', 'ConsumidorController@atualizarSenha')->name('consumidor.atualizarSenha');

    // Rotas para pedidos do Consumidor
    Route::get('/meusPedidos', 'ConsumidorController@pedidos')->name('consumidor.meusPedidos');
    Route::get('/meusPedidos/{pedido_id}', 'ConsumidorController@itensPedido')->name('consumidor.pedido.itens');
    Route::get('/editarPedido/{id}','ConsumidorController@editarPedido')->name('consumidor.pedido.editar');
    Route::get('/cancelarPedido/{id}', "ConsumidorController@cancelarPedido")->name('consumidor.pedido.cancelar');
    Route::get('/removerProdutoPedido/{idItemPedido}','ConsumidorController@removerPedido')->name('consumidor.pedido.remover');
    Route::post('/atualizarPedido', "ConsumidorController@atualizarPedido")->name('consumidor.pedido.atualizar');

    // Rotas para Grupo de Consumo
    Route::get('/adicionarGrupoConsumo',  'GrupoConsumoController@novo')->name('grupoConsumo.novo');
    Route::get('/editarGrupoConsumo/{id}', 'GrupoConsumoController@editar')->name('grupoConsumo.editar');
    Route::get('/gruposConsumo', 'GrupoConsumoController@listar')->name('grupoConsumo.listar');
    Route::get('/gerenciar/{id}', 'GrupoConsumoController@gerenciar')->name('grupoConsumo.gerenciar');
    Route::get('/grupoconsumo/sair/{grupoConsumoId}', 'GrupoConsumoController@sair')->name('grupoConsumo.sair');
    Route::post('/cadastrarGrupoConsumo', 'GrupoConsumoController@cadastrar')->name('grupoConsumo.cadastrar');
    Route::post('/atualizarGrupoConsumo', "GrupoConsumoController@atualizar")->name('grupoConsumo.atualizar');

    // Rotas para Eventos
    Route::get('/adicionarEvento/{idGrupoConsumo}',  'EventoController@novo')->name('evento.novo');
    Route::get('/eventos/{idGrupoConsumo}', 'EventoController@listar')->name('evento.listar');
    Route::get('/evento/pedidos/{evento_id}', 'EventoController@pedidos')->name('evento.pedidos');
    Route::get('/evento/pedidos/itens/{pedido_id}', 'EventoController@itensPedido')->name('evento.pedido.itens');
    Route::get('/evento/fechar/{eventoId}', 'EventoController@fecharEvento')->name('evento.fechar');
    Route::post('/cadastrarEvento', 'EventoController@cadastrar')->name('evento.cadastrar');

    // Rotas para Loja
    Route::get('/loja', 'LojaController@gruposConsumoUsuario')->name('loja');
    Route::get('/loja/evento/{id}','LojaController@produtosEvento')->name('loja.evento');

    // Rotas para Carrinho
    Route::post('/carrinho', 'PedidoController@confirmar')->name('carrinho');
    Route::post('/pedidoFinalizado', 'PedidoController@finalizar')->name('pedido.finalizar');

    Route::get('/visualizarPedido/{id}','PedidoController@visualizar')->name('pedido.visualizar');;

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/', function(){
        return redirect()->action('HomeController@index');
    });

    // Rotas para relatorios
    Route::get('/evento/pedidos/relatorioProdutor/{evento_id}', 'PdfController@criarRelatorioPedidosProdutores')->name('evento.relatorio.produtores');
    Route::get('/evento/pedidos/relatorioConsumidor/{evento_id}', 'PdfController@criarRelatorioPedidosConsumidores')->name('evento.relatorio.consumidores');
    Route::get('/evento/pedidos/relatorioComposicao/{evento_id}', 'PdfController@criarRelatorioMontagemPedidos')->name('evento.relatorio.montagem');

    //Rotas para emails
    Route::post('/share/mail','MyMailController@emailCompartilhar')->name('compartilhar.post');

    //Rotas para Locais de Retirada
    Route::get('/grupoconsumo/{grupoconsumo_id}/locaisretirada/listar','LocalRetiradaController@listar')->name('locaisretirada.listar');
    Route::get('/grupoconsumo/{grupoconsumo_id}/locaisretirada/adicionar','LocalRetiradaController@adicionar')->name('locaisretirada.adicionar'); //todo
    Route::post('/locaisretirada/criar','LocalRetiradaController@criar')->name('locaisretirada.criar'); //todo
    Route::get('/grupoconsumo/{grupoconsumo_id}/locaisretirada/editar/{localretirada_id}','LocalRetiradaController@editar')->name('locaisretirada.editar'); //todo
    Route::post('/locaisretirada/atualizar','LocalRetiradaController@atualizar')->name('locaisretirada.atualizar'); //todo
    Route::get('/grupoconsumo/{grupoconsumo_id}/locaisretirada/remover/{localretirada_id}','LocalRetiradaController@remover')->name('locaisretirada.remover'); //todo
});
