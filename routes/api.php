<?php


use App\Http\Controllers\Api\Armazens\ArmazemCreateController;
use App\Http\Controllers\Api\Armazens\ArmazemIndexController;
use App\Http\Controllers\Api\Armazens\ArmazemShowController;
use App\Http\Controllers\Api\Armazens\ArmazemUpdateController;
use App\Http\Controllers\Api\Auth\EmpresaAuthController;
use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\Auth\ClienteAuthController;
use App\Http\Controllers\Api\Auth\MvClienteAuthController;
use App\Http\Controllers\Api\Bancos\BancoCreateController;
use App\Http\Controllers\Api\Bancos\BancoIndexController;
use App\Http\Controllers\Api\Bancos\BancoShowController;
use App\Http\Controllers\Api\Bancos\BancoUpdateController;
use App\Http\Controllers\Api\Categorias\CategoriaIndexController;
use App\Http\Controllers\Api\Classificacao\ClassificarProdutoCrontroller;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\Clientes\ClienteCreateController;
use App\Http\Controllers\Api\Clientes\ClienteIndexController;
use App\Http\Controllers\Api\Clientes\ClienteShowController;
use App\Http\Controllers\Api\Clientes\ClienteUpdateController;
use App\Http\Controllers\Api\FabricanteController;
use App\Http\Controllers\Api\Fabricantes\FabricanteCreateController;
use App\Http\Controllers\Api\Fabricantes\FabricanteIndexController;
use App\Http\Controllers\Api\Fabricantes\FabricanteShowController;
use App\Http\Controllers\Api\Fabricantes\FabricanteUpdateController;
use App\Http\Controllers\Api\FacturaController;
use App\Http\Controllers\Api\Facturas\FacturaCreateController;
use App\Http\Controllers\Api\Facturas\FacturaIndexController;
use App\Http\Controllers\Api\FechoCaixa\FechoCaixaController;
use App\Http\Controllers\Api\FornecedorController;
use App\Http\Controllers\Api\Fornecedores\FornecedorCreateController;
use App\Http\Controllers\Api\Fornecedores\FornecedorIndexController;
use App\Http\Controllers\Api\Fornecedores\FornecedorShowController;
use App\Http\Controllers\Api\Fornecedores\FornecedorUpdateController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\MotivoIvaController;
use App\Http\Controllers\Api\MVProdutoFavorito\MVProdutoFavoritoController;
use App\Http\Controllers\Api\Operacoes\ActualizarStockController;
use App\Http\Controllers\Api\Operacoes\TransferenciaProdutoController;
use App\Http\Controllers\Api\PaisController;
use App\Http\Controllers\Api\Produtos\ProdutoIndexController;
use App\Http\Controllers\Api\Produtos\ProdutoCreateController;
use App\Http\Controllers\Api\Produtos\ProdutoUpdateController;
use App\Http\Controllers\Api\RelatorioVendasController;
use App\Http\Controllers\Api\StatuGeralController;
use App\Http\Controllers\Api\TaxaIvaController;
use App\Http\Controllers\Api\Utilizadores\UserController;
use App\Http\Controllers\Api\Utilizadores\UserUpdatePasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\empresa\CategoriaController;
use App\Http\Controllers\empresa\ClienteController as EmpresaClienteController;
use App\Http\Controllers\empresa\Facturas\FacturasIndexController;
use App\Http\Controllers\empresa\LicencaController as EmpresaLicencaController;
use App\Http\Controllers\empresa\UnidadeController;
use App\Http\Controllers\Portal\CarrinhoProdutoController;
use App\Http\Controllers\Portal\CarrinhoProdutoCrontroller;
use App\Http\Controllers\RegimeController;
use App\Http\Controllers\TipoEmpresaController;


use App\Http\Controllers\Portal\PortalProdutoController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 *ROTAS EMPRESA
 */



Route::post('/empresa/usuario/login', [EmpresaAuthController::class, 'auth']);
Route::post('/admin/usuario/login', [AdminAuthController::class, 'auth']);
Route::get('/listarRegimeEmpresa', [RegimeController::class, 'index']);
Route::get('/listarTipoEmpresa', [TipoEmpresaController::class, 'index']);
Route::get('/listarPaises', [PaisController::class, 'index']);
Route::get('/listarStatusGeral', [StatuGeralController::class, 'index']);
Route::get('empresa/listarTipoClientes', [EmpresaClienteController::class, 'listarTipoClienteApi']);


// @Zuadas MUTUE VENDAS ONLINE
Route::group(['prefix' => 'portal'], function () {
    // Route::get('/teste', [App\Http\Controllers\Portal\CarrinhoProdutoController::class, 'index']);
    // Route::get('/teste', [App\Http\Controllers\Portal\CarrinhoProdutoController::class, 'index']);
    // Route::get('/portal/cart/add/product/{id}', [App\Http\Controllers\Portal\CarrinhoProdutoController::class, 'addProdutoNoCarrinho']);

});
// @Zuadas MUTUE VENDAS ONLINE
Route::group(['prefix' => 'portal'], function () {
    // Route::get('/teste', [App\Http\Controllers\Portal\CarrinhoProdutoController::class, 'index']);
    //empresa api mutue vendas api
    Route::get("/produto/detalhes/{id}",  [PortalProdutoController::class, 'getPodutoDetalhes']);
    Route::get("/produtos/pesquisar/{id}",  [PortalProdutoController::class, 'pesquisarProdutoById']);
    Route::get("/listarProdutos",  [ProdutoIndexController::class, 'mv_listarProdutos']);

    Route::get("/listarCategorias",  [CategoriaIndexController::class, 'mv_listarCategoriasSemPaginacao']);

    Route::post('/user/login', [MvClienteAuthController::class, 'auth']);
    // @Zuadas Rotas do Carrinho

    Route::get("/listarCategorias",  [CategoriaIndexController::class, 'mv_listarCategoriasSemPaginacao']);
    Route::post('/user/login', [MvClienteAuthController::class, 'auth']);
    // @Zuadas Rotas do Carrinho

    Route::middleware(['auth:sanctum'])->group(function () {
        // Route::get('/encrease/qty/produto/{id}', [CarrinhoProdutoController::class, 'encreaseCarrinhoQtyProduto']);
        Route::post('/decrease/qty/produto', [CarrinhoProdutoController::class, 'decreaseCarrinhoQtyProduto']);
        Route::post('/add/produto', [CarrinhoProdutoController::class, 'addProdutoNoCarrinho']);
        Route::get('/get/my/produtos', [CarrinhoProdutoController::class, 'getCarrinhoProdutos']);
        Route::delete('/remover/produto/carrinho/{id}', [CarrinhoProdutoController::class, 'removerCarrinho']);
        Route::get('/listar/carrinho/produto/{uuid}', [CarrinhoProdutoController::class, 'getCarrinhoProduto']);
    });
    // @Zuadas Rotas do Carrinho
});
// @Zuadas MUTUE VENDAS ONLINE

Route::post('/user/login', [MvClienteAuthController::class, 'auth']);
Route::get("/user/meAuth", [MvClienteAuthController::class, 'me']);


//CLIENTES
Route::post('validarEmpresa', [RegisterController::class, 'validarEmpresa']);
Route::post('register', [RegisterController::class, 'register']);

//empresa api mutue negocios api
Route::middleware(['auth:sanctum'])->prefix('empresa')->group(function () {
    Route::get('buscarDadosTeste/{id}', [ClassificarProdutoCrontroller::class, 'buscarDadosTeste']);
    // Route::get('add/produto/{id}', [CarrinhoProdutoController::class, 'addProdutoNoCarrinho']);
    Route::post('classificarProduto', [ClassificarProdutoCrontroller::class, 'mv_classificarProduto']);
    //Home
    Route::get('countDashboard', [HomeController::class, 'countDashboard']);
    // Route::get('quantidadeUtilizadores', [UserController::class, 'quantidadeUtilizadores']);
    // Route::get('quantidadeClientes', [ClienteIndexController::class, 'quantidadeClientes']);
    // Route::get('quantidadeArmazens', [ArmazemIndexController::class, 'quantidadeArmazens']);
    // Route::get('quantidadeFornecedores', [FornecedorIndexController::class, 'quantidadeFornecedores']);
    // Route::get('quantidadeFabricantes', [FabricanteIndexController::class, 'quantidadeFabricantes']);
    // Route::get('quantidadeBancos', [BancoIndexController::class, 'quantidadeBancos']);
    // Route::get('quantidadeProdutos', [ProdutoIndexController::class, 'quantidadeProdutos']);
    // Route::get('quantidadesVendas', [FacturaIndexController::class, 'quantidadesVendas']);
    // Route::get('totalVendas', [FacturaIndexController::class, 'totalVendas']);
    // Route::get('listarGraficoVendasMensal', [FacturaIndexController::class, 'listarGraficoVendasMensal']);
    // Route::get('listarSeisProdutosMaisVendidos', [ProdutoIndexController::class, 'listarSeisProdutosMaisVendidos']);

    //Fim home
    Route::post('produtos/actualizarStock', [ActualizarStockController::class, 'actualizarStock']);
    Route::get('listarAtualizacaoStock', [ActualizarStockController::class, 'listarAtualizacaoStock']);
    //++
    Route::get('usuario/me', [EmpresaAuthController::class, 'me']);
    //DADOS EMPRESA
    Route::get('listarDadoEmpresa', [EmpresaAuthController::class, 'getEmpresa']);

    Route::get('/listarPaises', [PaisController::class, 'index']);
    Route::get('usuario/me', [EmpresaAuthController::class, 'me']);
    Route::post('usuario/logout', [EmpresaAuthController::class, 'logout']);
    Route::get('planos-assinaturas', [EmpresaLicencaController::class, 'index']);
    Route::get('facturas', [FacturaController::class, 'listarFacturas']);
    Route::post('factura/nova', [FacturaCreateController::class, 'store']);
    Route::get('facturas/imprimirFactura/{id}/{tipoFolha}', [FacturaController::class, 'imprimirFactura']);

    //PRODUTO
    Route::get('produtos', [ProdutoIndexController::class, 'listarProdutos']);
    Route::get('produto/{id}', [ProdutoIndexController::class, 'getproduto']);
    Route::get('produtos/armazem/{id}', [ProdutoIndexController::class, 'listarProdutosPeloIdArmazem']);
    Route::post('cadastrarproduto', [ProdutoCreateController::class, 'store']);
    Route::put('actualizarproduto/{id}', [ProdutoUpdateController::class, 'update']);
    Route::post('transferenciaProdutos', [TransferenciaProdutoController::class, 'store']);
    Route::get('listarTransferencias', [TransferenciaProdutoController::class, 'listarTransferencias']);

    //CATEGORIA DE PRODUTOS
    Route::get('categorias', [CategoriaController::class, 'listarCategorias']);

    //UNIDADE DE MEDIDAS DE PRODUTOS
    Route::get('unidadeMedidas', [UnidadeController::class, 'listarUnidadeMedidas']);


    //ARMAZENS
    Route::get('armazens', [ArmazemIndexController::class, 'listarArmazens']);
    Route::get('armazem/{id}', [ArmazemShowController::class, 'listarArmazem']);
    Route::post('armazens', [ArmazemCreateController::class, 'store']);
    Route::put('armazem/{id}', [ArmazemUpdateController::class, 'update']);

    //USUARIOS
    Route::get('armazens', [ArmazemIndexController::class, 'listarArmazens']);
    Route::get('armazem/{id}', [ArmazemShowController::class, 'listarArmazem']);
    Route::post('armazens', [ArmazemCreateController::class, 'store']);
    Route::put('armazem/{id}', [ArmazemUpdateController::class, 'update']);

    //FORNECEDORES
    Route::get('fornecedores', [FornecedorIndexController::class, 'listarFornecedores']);
    Route::get('fornecedor/{id}', [FornecedorShowController::class, 'listarFornecedor']);
    Route::post('cadastrarFornecedores', [FornecedorCreateController::class, 'store']);
    Route::put('actualizarFornecedor/{id}', [FornecedorUpdateController::class, 'update']);

    //FABRICANTE
    Route::get('fabricantes', [FabricanteIndexController::class, 'listarFabricantes']);
    Route::get('fabricante/{id}', [FabricanteShowController::class, 'listarFabricante']);
    Route::post('CadastrarFabricante', [FabricanteCreateController::class, 'store']);
    Route::put('actualizarFabricante/{id}', [FabricanteUpdateController::class, 'update']);

    //BANCOS
    Route::get('bancos', [BancoIndexController::class, 'listarBancos']);
    Route::get('banco/{id}', [BancoShowController::class, 'listarBanco']);
    Route::post('cadastrarBancos', [BancoCreateController::class, 'store']);
    Route::put('actualizarBanco/{id}', [BancoUpdateController::class, 'update']);

    //CLIENTES
    Route::get('clientes', [ClienteIndexController::class, 'listarClientes']);
    Route::get('cliente/{id}', [ClienteShowController::class, 'listarCliente']);
    Route::post('cadastrarCliente', [ClienteCreateController::class, 'store']);
    Route::put('actualizarCliente/{id}', [ClienteUpdateController::class, 'update']);

    //UTILIZADORES
    Route::post('alterarSenha', [UserUpdatePasswordController::class, 'updatePassword']);
    //FECHO DE CAIXA
    Route::get('imprimirFechoCaixa', [FechoCaixaController::class, 'imprimirFechoCaixa']);

    //Clientes
    // Route::get('clientes', [ClienteController::class, 'getClientes']);
    // Route::get('cliente/{id}', [ClienteController::class, 'getCliente']);
    // Route::post('cadastrarCliente', [ClienteController::class, 'store']);
    // Route::put('actualizarCliente/{id}', [ClienteController::class, 'update']);
    Route::get('imprimirClientes', [ClienteIndexController::class, 'imprimirClientes']);

    //FECHO DE CAIXA
    // Route::get('imprimirFechoCaixa', [FechoCaixaController::class, 'imprimirFechoCaixa']);

    //RELATORIO DE VENDA
    Route::get('imprimirVendaDiaria', [RelatorioVendasController::class, 'imprimirVendaDiaria']);
    Route::get('imprimirVendaMensal', [RelatorioVendasController::class, 'imprimirVendaMensal']);
    Route::get('imprimirVendaAnual', [RelatorioVendasController::class, 'imprimirVendaAnual']);

    //IVA
    Route::get('taxas', [TaxaIvaController::class, 'listarTaxas']);
    Route::get('motivos', [MotivoIvaController::class, 'listarMotivos']);

    //API MUTUE VENDAS
    Route::get("/listarProdutosFavoritos",  [MVProdutoFavoritoController::class, 'mv_listarProdutosFavoritos']);
    Route::post("/checkFavorito",  [MVProdutoFavoritoController::class, 'checkFavorito']);
    Route::get("/isProdutoFavorito/{produtoId}",  [MVProdutoFavoritoController::class, 'isProdutoFavorito']);
});


//empresa api mutue vendas api
Route::get("/listarProdutos",  [ProdutoIndexController::class, 'mv_listarProdutos']);
Route::get("/listarComentarioPorProduto/{produtoId}",  [ProdutoIndexController::class, 'mv_listarComentarioPorProduto']);

Route::get("/listarCategorias",  [CategoriaIndexController::class, 'mv_listarCategoriasSemPaginacao']);

//admin
Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    Route::get('usuario/me', [AdminAuthController::class, 'me']);
    Route::post('usuario/logout', [AdminAuthController::class, 'logout']);
});





/**
 * ROTAS ANTIGAS
 */

/*

Route::post('empresa/usuario/login', 'Api\\EmpresaAuthController@login'); //feito
Route::post('empresa/usuario/logout', 'Api\\EmpresaAuthController@logout'); //feito
Route::get('empresa/usuario/me', 'Api\\EmpresaAuthController@me'); //feito
Route::get('listarRegimeEmpresa', 'admin\EmpresaController@listarRegimeEmpresa'); //feito
Route::get('listarTipoEmpresa', 'admin\EmpresaController@listarTipoEmpresa'); //feito
Route::get('empresa/listarPaises', 'empresa\ClienteController@listarPaisesApi'); //feito

Route::post('admin/empresa/adicionar', 'admin\EmpresaController@cadastrarEmpresaApi'); //FALTA

Route::group(['middleware' => 'apiJwt'], function () {

    Route::get('empresa/facturas', 'empresa\FacturaController@indexApi'); //feito
    Route::post('empresa/facturas/adicionar', 'empresa\FacturacaoController@storeApi');
    Route::get('empresa/facturas/imprimir-factura/{id}/{tipoFolha}', 'empresa\FacturacaoController@imprimirFacturaApi');
    Route::get('empresa/facturas/reimprimir-factura/{id}', 'empresa\FacturacaoController@reimprimirFacturaApi');
    Route::get('empresa/facturacao/produtos/{armazen_id}', 'empresa\FacturacaoController@listarProdutosApi');



    Route::get('empresa/taxas', 'empresa\TaxaIvaController@listarTaxas');
    Route::get('empresa/motivos', 'admin\MotivoIvaController@listarMotivos');
    Route::get('empresa/fabricantes', 'empresa\FabricanteController@listarFabricantes');
    Route::get('empresa/listarArmazens', 'empresa\ArmazenController@listarArmazens');
    Route::get('empresa/listarFornecedores', 'empresa\FornecedorController@listarFornecedoresApi');
    Route::get('empresa/formaPagamentos', 'empresa\FormaPagamentoController@listarFormaPagamento');
    Route::get('empresa/tipoDocumentos', 'empresa\TipoDocumentoController@listarTipoDocumentos');
    Route::get('empresa/marcas', 'empresa\MarcaController@listarMarcas');
    Route::get('empresa/categorias', 'empresa\CategoriaController@listarCategorias');
    Route::get('empresa/classes', 'empresa\ClasseController@listarClasses');
    Route::get('empresa/unidadeMedidas', 'empresa\UnidadeController@listarUnidadeMedidas');
    Route::get('empresa/clientes', 'empresa\ClienteController@listarClienteApi');
    Route::get('empresa/cliente/{clienteId}', 'empresa\ClienteController@ApiListaCliente');
    Route::get('empresa/listarClientes', 'empresa\ClienteController@listarClientesApi');
    Route::get('empresa/produtos', 'empresa\ProdutoController@indexApi');
    Route::get('/empresa/produto/{produtoId}', 'empresa\ProdutoController@listarProduto');
    Route::post('/empresa/armazens/adicionar', 'empresa\ArmazenController@storeApi');
    Route::post('empresa/clientes/adicionar', 'empresa\ClienteController@storeApi');
    Route::post('empresa/clientes/actualizar/{id}', 'empresa\ClienteController@updateApi');
    Route::post('/empresa/produtos/adicionar', 'empresa\ProdutoController@storeApi');
    Route::put('empresa/usuario/alterarSenha/{userId}', 'empresa\UserController@alterarSenhaApi');

    //Dependencias
    //Route::get('empresa/listarPaises', 'empresa\ClienteController@listarPaisesApi');
    Route::get('empresa/listarTipoClientes', 'empresa\ClienteController@listarTipoClienteApi');
    Route::post('empresa/fechocaixa/imprimir', 'empresa\FechoCaixaController@imprimirFechoCaixaApi'); //falta
    Route::post('/empresa/produtos/editar/{id}', 'empresa\ProdutoController@updateApi');
    Route::post('empresa/entradaStock', 'empresa\StockController@entradaStockApi'); //FALTA
    //fecho de caixa
});

*/

/**
 * ROTAS ADMIN
 */

// Route::post('admin/usuario/login', 'Api\\AdminAuthController@login');
// Route::post('admin/usuario/logout', 'Api\\AdminAuthController@logout');














//faltantes






Route::group(['middleware' => ['apiJwt']], function () {

    Route::post('admin/logout', 'Api\\AdminAuthController@logout');
    Route::post('admin/me', 'Api\\AdminAuthController@me');
    Route::get('admin/usuarios', 'Api\\UserController@index');


    //licencas
    Route::post('/admin/licencas/adicionar', 'admin\LicencaController@store');
});

/**
 * ROTAS DA EMPRESA
 */
//Route::post('empresa/login', 'Api\\FuncionarioAuthController@login');

Route::group(['middleware' => ['apiJwt']], function () {

    Route::post('empresa/logout', 'Api\\FuncionarioAuthController@logout');
    Route::post('empresa/me', 'Api\\FuncionarioAuthController@me');
    //produtos
    //Route::post('/empresa/produtos/editar/{id}', 'empresa\ProdutoController@update');

    //stock
    //Route::post('empresa/entradaStock', 'empresa\StockController@entradaStock');

    //fornecedores

    //Route::post('empresa/produtos/actualizarStock', 'empresa\ExistenciaStockController@actualizarStock');//++
    //Route::post('empresa/produtos/transferencia/salvar', 'empresa\StockController@transferenciaSalvar');//++



    //fecho de caixa
    // Route::post('empresa/fechocaixa/imprimir', 'empresa\FechoCaixaController@imprimirFechoCaixa');//falta

    //usuário
});
