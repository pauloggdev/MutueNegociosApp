<?php

use App\Http\Controllers\admin\AtivacaoLicencaController;
use App\Http\Controllers\admin\BancoController;
use App\Http\Controllers\admin\ConfiguracaoController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\admin\EmpresaController as AdminEmpresaController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\LicencaController;
use App\Http\Controllers\admin\NotificacaoController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthClienteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\empresa\ArmazenController;
use App\Http\Controllers\empresa\BancoController as EmpresaBancoController;
use App\Http\Controllers\empresa\CategoriaController;
use App\Http\Controllers\empresa\CentroCustoController;
use App\Http\Controllers\empresa\ClasseController;
use App\Http\Controllers\empresa\ClienteController;
use App\Http\Controllers\empresa\ConfiguracaoController as EmpresaConfiguracaoController;
use App\Http\Controllers\empresa\EmpresaController;
use App\Http\Controllers\empresa\ExistenciaStockController;
use App\Http\Controllers\empresa\FabricanteController;
use App\Http\Controllers\empresa\FacturacaoController;
use App\Http\Controllers\empresa\FacturaController;
use App\Http\Controllers\empresa\FechoCaixaController;
use App\Http\Controllers\empresa\FinalizarVendaController;
use App\Http\Controllers\empresa\FormaPagamentoController;
use App\Http\Controllers\empresa\FornecedorController;
use App\Http\Controllers\empresa\GestorController;
use App\Http\Controllers\empresa\InventarioController;
use App\Http\Controllers\empresa\LicencaController as EmpresaLicencaController;
use App\Http\Controllers\empresa\MarcaController;
use App\Http\Controllers\empresa\MotivoIvaController;
use App\Http\Controllers\empresa\NotaCreditoAnulacaoDocumentos\AnulacaoDocumentoFacturaCreateController;
use App\Http\Controllers\empresa\NotaCreditoAnulacaoDocumentos\AnulacaoDocumentoIndexController;
use App\Http\Controllers\empresa\NotaCreditoAnulacaoDocumentos\AnulacaoDocumentoReciboCreateController;
use App\Http\Controllers\empresa\NotaCreditoAnulacaoDocumentos\RetificacaoDocumentoCreateController;
use App\Http\Controllers\empresa\NotaCreditoAnulacaoDocumentos\RetificacaoDocumentoIndexController;
use App\Http\Controllers\empresa\NotaCreditoSaldoCliente\NotaCreditoCreateController;
use App\Http\Controllers\empresa\NotaCreditoSaldoCliente\NotaCreditoIndexController;
use App\Http\Controllers\empresa\NotaDebitoSaldoCliente\NotaDebitoCreateController;
use App\Http\Controllers\empresa\NotaDebitoSaldoCliente\NotaDebitoIndexController;
use App\Http\Controllers\empresa\NotificacaoController as EmpresaNotificacaoController;
use App\Http\Controllers\empresa\OperacaoController;
use App\Http\Controllers\empresa\PagamentoController;
use App\Http\Controllers\empresa\PdvController;
use App\Http\Controllers\empresa\PermissionController as EmpresaPermissionController;
use App\Http\Controllers\empresa\ProdutoController;
use App\Http\Controllers\empresa\Produtos\ProdutoCreateController;
use App\Http\Controllers\empresa\Produtos\ProdutoShowController;
use App\Http\Controllers\empresa\Produtos\ProdutoStoreController;
use App\Http\Controllers\empresa\Produtos\ProdutoUpdateController;
use App\Http\Controllers\empresa\Recibos\ReciboCreateController;
use App\Http\Controllers\empresa\Recibos\ReciboIndexController;
use App\Http\Controllers\empresa\RelatorioController;
use App\Http\Controllers\empresa\ReportController;
use App\Http\Controllers\empresa\RoleController as EmpresaRoleController;
use App\Http\Controllers\empresa\RolesPermissionController;
use App\Http\Controllers\empresa\StockController;
use App\Http\Controllers\empresa\TaxaIvaController;
use App\Http\Controllers\empresa\TipoDocumentoController;
use App\Http\Controllers\empresa\UnidadeController;
use App\Http\Controllers\empresa\UserController;
use App\Http\Controllers\empresa\VendaController;
use App\Http\Controllers\frontOffice\FrontOfficeController;
use App\Http\Controllers\GenericoController;
use App\Http\Controllers\HomeController as EmpresaHomeController;

use App\Http\Controllers\empresa\Clientes\ClienteCreateController;
use App\Http\Controllers\empresa\Clientes\ClienteIndexController;
use App\Http\Controllers\empresa\Clientes\ClienteShowController;
use App\Http\Controllers\empresa\Clientes\ClienteUpdateController;


// Fabricantes
use App\Http\Controllers\empresa\Fabricantes\FabricanteIndexController;
use App\Http\Controllers\empresa\Fabricantes\FabricanteCreateController;
use App\Http\Controllers\empresa\Fabricantes\FabricanteUpdateController;

// Bancos
use App\Http\Controllers\empresa\Bancos\BancoIndexController;
use App\Http\Controllers\empresa\Bancos\BancoCreateController;
use App\Http\Controllers\empresa\Bancos\BancoUpdateController;

use App\Http\Controllers\empresa\Roles\RoleController;






// use Admins
use App\Http\Controllers\admin\HomeController as AdminHomeController;
use App\Http\Controllers\admin\Users\UserIndexController as AdminUserIndexController;
use App\Http\Controllers\admin\Users\UserCreateController as AdminUserCreateController;
use App\Http\Controllers\admin\Users\UserUpdateController as AdminUserUpdateController;
use App\Http\Controllers\admin\Users\UserShowController as AdminUserShowController;
use App\Http\Controllers\admin\Users\UserUpdatePasswordController as AdminUserUpdatePasswordController;
use App\Http\Controllers\admin\BackupBancoIndexController as AdminBackupBancoIndexController;
use App\Http\Controllers\admin\PedidosLicenca\PedidoLicencaAtivarIndexController as AdminPedidoLicencaAtivarIndexController;
use App\Http\Controllers\admin\PedidosLicenca\PedidosLicencaIndexController as AdminPedidosLicencaIndexController;
use App\Http\Controllers\admin\PedidosLicenca\PedidoLicencaDetalhesShowController as AdminPedidoLicencaDetalhesShowController;
use App\Http\Controllers\admin\PedidosLicenca\PedidoLicencaRejeitadoIndexController as AdminPedidoLicencaRejeitadoIndexController;
use App\Http\Controllers\admin\Configuracao\MinhaContaIndexController as AdminMinhaContaIndexController;
use App\Http\Controllers\admin\CoordernadaBancariaController;




// Bancos
use App\Http\Controllers\admin\Bancos\BancoIndexController as AdminBancoIndexController;
use App\Http\Controllers\admin\Bancos\BancoCreateController as AdminBancoCreateController;
use App\Http\Controllers\admin\Bancos\BancoUpdateController as AdminBancoUpdateController;

// Clientes
use App\Http\Controllers\admin\Clientes\ClienteIndexController as AdminClienteIndexController;
use App\Http\Controllers\admin\Clientes\ClienteDetalhesController as AdminClienteDetalhesController;
// Licenças
use App\Http\Controllers\admin\Licencas\LicencaIndexController as AdminLicencaIndexController;

//Empresa
use App\Http\Controllers\empresa\Empresa\EmpresaIndexController;

// TaxaIva
use App\Http\Controllers\admin\TaxaIva\TaxaIvaIndexController as AdminTaxaIvaIndexController;
use App\Http\Controllers\admin\TaxaIva\TaxaIvaCreateController as AdminTaxaIvaCreateController;
use App\Http\Controllers\admin\TaxaIva\TaxaIvaUpdateController as AdminTaxaIvaUpdateController;

// Motivo Isenção
use App\Http\Controllers\admin\MotivoIsencao\MotivoIsencaoIndexController as AdminMotivoIsencaoIndexController;
use App\Http\Controllers\admin\MotivoIsencao\MotivoIsencaoCreateController as AdminMotivoIsencaoCreateController;
use App\Http\Controllers\admin\MotivoIsencao\MotivoIsencaoUpdateController as AdminMotivoIsencaoUpdateController;
// use App\Http\Controllers\admin\Bancos\BancoCreateController as AdminBancoCreateController;
// use App\Http\Controllers\admin\Bancos\BancoUpdateController as AdminBancoUpdateController;

use App\Http\Controllers\admin\MotivoIvaController as AdminMotivoIvaController;
use App\Http\Controllers\admin\PedidoUtilizador\AdminPedidosAtivacaoUtilizadorIndexController;
use App\Http\Controllers\admin\TaxaIvaController as AdminTaxaIvaController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\empresa\Armazens\ArmazemCreateController;
use App\Http\Controllers\empresa\Armazens\ArmazemIndexController;
use App\Http\Controllers\empresa\Armazens\ArmazemUpdateController;
use App\Http\Controllers\empresa\Assinaturas\AssinaturaIndexController;
use App\Http\Controllers\empresa\FormasPagamento\FormaPagamentoIndexController;
use App\Http\Controllers\empresa\Categorias\CategoriaCreateController;
use App\Http\Controllers\empresa\Categorias\CategoriaIndexControlle;
use App\Http\Controllers\empresa\Categorias\CategoriaIndexController;
use App\Http\Controllers\empresa\Categorias\CategoriaUpdateController;
use App\Http\Controllers\empresa\Categorias\CategoriaUpdateSubCategoriaController;
use App\Http\Controllers\empresa\CentroCustos\CentroCustoCreateController;
use App\Http\Controllers\empresa\CentroCustos\CentroCustoIndexController;
use App\Http\Controllers\empresa\CentroCustos\CentroCustoRelatorioIndexController;
use App\Http\Controllers\empresa\CentroCustos\CentroCustoUpdateController;
use App\Http\Controllers\empresa\Clientes\ClienteExtratoController;
use App\Http\Controllers\empresa\Clientes\FornecedorIndexController as ClientesFornecedorIndexController;
use App\Http\Controllers\empresa\Empresa\EmpresaUpdateController;
use App\Http\Controllers\empresa\EntradaProduto\EntradaProdutoCreateController;
use App\Http\Controllers\empresa\EntradaProduto\EntradaProdutoIndexController;
use App\Http\Controllers\empresa\Facturas\FacturaProformaIndexController;
use App\Http\Controllers\empresa\Facturas\FacturasIndexController;
use App\Http\Controllers\empresa\FechoCaixa\FechoCaixaIndexController;
use App\Http\Controllers\empresa\Fornecedores\FornecedorCreateController;
use App\Http\Controllers\empresa\Fornecedores\FornecedorIndexController;
use App\Http\Controllers\empresa\Fornecedores\FornecedorShowController;
use App\Http\Controllers\empresa\Fornecedores\FornecedorUpdateController;
use App\Http\Controllers\empresa\Licencas\MinhaLicencaController;
use App\Http\Controllers\empresa\ManualUtilizador\ManualUtilizadorIndexController;
use App\Http\Controllers\empresa\Marcas\MarcaCreateController;
use App\Http\Controllers\empresa\Marcas\MarcaIndexController;
use App\Http\Controllers\empresa\Marcas\MarcaUpdateController;
use App\Http\Controllers\empresa\ModeloDocumentos\ModeloDocumentoController;
use App\Http\Controllers\empresa\Permissao\PermissaoIndexController;
use App\Http\Controllers\empresa\Permissao\SemPermissaoController;
use App\Http\Controllers\empresa\Produtos\ProdutoIndexController;
use App\Http\Controllers\empresa\Roles\RoleCreateController;
use App\Http\Controllers\empresa\Roles\RoleIndexController;
use App\Http\Controllers\empresa\Roles\RolePermissoesIndexController;
use App\Http\Controllers\empresa\Roles\RoleUpdateController;
use App\Http\Controllers\empresa\Safts\GerarSaftController;
use App\Http\Controllers\empresa\UnidadeMedidas\UnidadeMedidaCreateController;
use App\Http\Controllers\empresa\UnidadeMedidas\UnidadeMedidaIndexController;
use App\Http\Controllers\empresa\UnidadeMedidas\UnidadeMedidaUpdateController;
use App\Http\Controllers\empresa\Usuarios\UsuarioCreateController;
use App\Http\Controllers\empresa\Usuarios\UsuarioIndexController;
use App\Http\Controllers\empresa\Usuarios\UsuarioPermissoesIndexontroller;
use App\Http\Controllers\empresa\Usuarios\UsuarioUpdateController;
use App\Http\Controllers\empresa\Vendas\VendasDiariaIndexController;
use App\Http\Controllers\empresa\Vendas\VendasMensalIndexController;
use App\Jobs\JobCreateNewUser;
use App\Models\empresa\Armazen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// PedidoLicencaRejeitadoIndexController
use Illuminate\Support\Str;


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


Auth::routes();


// Route::get('/uuid', function () {

//     return view("alert.msg_criacao_empresa_mobile");

//     $clientes = DB::table('clientes')->get();

//     foreach ($clientes as $key => $cliente) {

//         DB::table('clientes')->where('id', $cliente->id)->update([
//             'uuid' => Str::uuid()
//         ]);
//     }
// });

Route::get('/user_perfil', function () {


    $users = DB::table('users_cliente')->get();

    foreach ($users as $key => $user) {

        DB::table('user_perfil')->insert([
            'user_id' => $user->id,
            'perfil_id' => 1
        ]);
    }
});



// Route::get('/csrf-cookie', function (Request $request) {
//     return response()->json(['csrf_token' => csrf_token()]);
// });

// ROTAS NOVAS V1
//Empresa
Route::get('/', [AppController::class, 'home']);
Route::get('/politica-privacidade', function () {
    return view("politicaPrivacidade");
});
Route::get('/home', [AppController::class, 'home'])->name('home');
Route::get('/cadastro-empresa', [AdminEmpresaController::class, 'create']);


Route::get('/criar-empresa', EmpresaIndexController::class);





// FIM ROTAS NOVAS V1
Route::get('/login', [AppController::class, 'home']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'empresa'], function () {
    Route::get('cliente-login', [AuthClienteController::class, 'showLoginForm'])->name('cliente-login');
    Route::post('login-cliente', [AuthClienteController::class, 'login'])->name('login-cliente');
});
Route::post('/validar-empresa', [RegisterController::class, 'validarEmpresa']);
Route::get('/register', [RegisterController::class, 'register']);

Route::group(['middleware' => 'web'], function () {
    Route::get('empresa-login', [LoginController::class, 'loginForm'])->name('empresa-login'); //Login ou autenticação das empresas;
    Route::get('/contacto', [FrontOfficeController::class, 'contactos']);
    Route::post('/contacto', [FrontOfficeController::class, 'enviarMensagem']);
    Route::get('/sobre', [FrontOfficeController::class, 'sobre']);
    Route::get('/servicos', [FrontOfficeController::class, 'servicos']);
});

/**
 * ROTAS GENERICAS
 *
 */
Route::get('/paises', [GenericoController::class, 'paises']);
Route::get('/tipoCliente', [GenericoController::class, 'tipoCliente']);
// Route::get('/tipoCliente', 'GenericoController@tipoCliente');

/**
 * ROTAS DA PARTE ADMINISTRATIVA
 */
//Rota página inicial

Route::group(['middleware' => ['auth']], function () {
    Route::get('/empresa/home', [EmpresaHomeController::class, 'index'])->name('home');
    Route::get('/empresa/infoDashboard', [EmpresaHomeController::class, 'infoDashboard']);
    Route::get('/perfil', [EmpresaHomeController::class, 'perfil'])->name('perfil');
    // Route::post('/update_senha/{id}', 'admin\UserController@update_senha');
    //Route::post('/alterar-password/{id}', 'admin\UserController@alterarPassword');

    Route::get('empresa/perfil', [HomeController::class, 'perfil'])->name('empresa/perfil');
    // Route::post('empresa/update_senha/{id}', 'empresa\UserController@update_senha');
});

//usuários admin

// Route::group(['middleware' => ['role_or_permission:Super-Admin|Admin', 'auth']], function () {

Route::group(['middleware' => ['auth:web']], function () {
    Route::prefix('admin')->group(function () {

        Route::get('/', [AdminHomeController::class, 'index'])->name('admin.home');
        Route::get('/home', [AdminHomeController::class, 'index']);
        // Utilizadores
        Route::get('/utilizadores', AdminUserIndexController::class)->name('admin.users.index');
        Route::get('/utilizador/novo', AdminUserCreateController::class)->name('admin.users.create');
        Route::get('/utilizador/editar/{utilizadorId}', AdminUserUpdateController::class)->name('admin.users.edit');
        Route::get('/utilizador/perfil', AdminUserUpdatePasswordController::class);
        Route::post('/utilizador/perfil', AdminUserUpdatePasswordController::class);
        // Bancos
        Route::get('/bancos', AdminBancoIndexController::class)->name('admin.bancos.index');
        Route::get('/banco/novo', AdminBancoCreateController::class)->name('admin.bancos.create');
        Route::get('/banco/editar/{uuid}', AdminBancoUpdateController::class)->name('admin.bancos.edit');

        // Clientes
        Route::get('/clientes', AdminClienteIndexController::class)->name('admin.clientes.index');
        Route::get('/cliente/{id}/detalhes', AdminClienteDetalhesController::class)->name('admin.clientes.detalhes');
        // Licenças
        Route::get('/licencas', AdminLicencaIndexController::class)->name('admin.licencas.index');

        // Taxa Iva
        Route::get('/taxaIva', AdminTaxaIvaIndexController::class)->name('taxaIva.index');
        Route::get('/taxaIva/novo', AdminTaxaIvaCreateController::class)->name('admin.taxas.create');
        Route::get('/taxaIva/editar/{id}', AdminTaxaIvaUpdateController::class)->name('admin.taxas.edit');

        // Motivo isencao
        Route::get('/motivoisencao', AdminMotivoIsencaoIndexController::class)->name('motivoIsencao.index');
        Route::get('/motivoisencao/novo', AdminMotivoIsencaoCreateController::class)->name('motivoIsencao.create');
        Route::get('/motivoisencao/edit/{id}', AdminMotivoIsencaoUpdateController::class)->name('motivoIsencao.edit');

        Route::get('/licenca/novo', AdminUserCreateController::class)->name('admin.licencas.create');
        Route::get('/licencas/editar/{uuid}', AdminUserUpdateController::class)->name('admin.licencas.edit');

        // Minha conta
        Route::get('/empresa/conta', AdminMinhaContaIndexController::class)->name('configContaEmpresa');


        // Pedidos de licenças
        Route::get('/pedidos/licenca', AdminPedidosLicencaIndexController::class)->name('admin.pedidosLicencas.index');
        Route::get('/pedido/licenca/{pedidoId}/detalhes', AdminPedidoLicencaDetalhesShowController::class)->name('pedidoLicencaDetalhes');
        Route::get('/pedido/licenca/{pedidoId}/rejeitar', AdminPedidoLicencaRejeitadoIndexController::class)->name('pedidoLicencaRejeitadoAdmin');
        Route::get('/pedido/licenca/{pedidoId}/ativar', AdminPedidoLicencaAtivarIndexController::class)->name('pedidoLicencaAtivarAdmin');
        Route::POST('/pedido/licenca/{pedidoId}/ativar', AdminPedidoLicencaAtivarIndexController::class)->name('pedidoLicencaAtivarAdmin');

        //Pedidos ativação dos utilizadores
        Route::get('/pedidos/ativacao/utilizadores', AdminPedidosAtivacaoUtilizadorIndexController::class)->name('pedidosActivacaoUtilizador');


        //Backup
        Route::get('/backup/banco',  AdminBackupBancoIndexController::class)->name('backupBancoIndex');
        Route::post('/backup/banco/cliente',  [AdminBackupBancoIndexController::class, 'exportarBancoCliente'])->name('exportarBancoDadoCliente');
        Route::post('/backup/banco/admin',  [AdminBackupBancoIndexController::class, 'exportarBancoAdmin'])->name('exportarBancoDadoAdmin');

        //notificações
        Route::get('admin/notifications', [NotificacaoController::class, 'notifications']);
        Route::get('admin/notificationsAll', [NotificacaoController::class, 'notificationsAll']);
        Route::put('admin/notificationsRead', [NotificacaoController::class, 'markAsRead']);
        Route::get('admin/listar-notificacoes', [NotificacaoController::class, 'listarNotificacoes']);
        Route::get('admin/notifications/deletar/{id}', [NotificacaoController::class, 'deletar']);

        //Empresa
        Route::post('admin/empresa/editar', [ConfiguracaoController::class, 'update']);
        Route::get('/admin/configuracao', [ConfiguracaoController::class, 'editarEmpresa']);



        //Utilizador
        Route::get('admin/usuarios', [AdminUserController::class, 'index']);
        Route::post('admin/utilizador/adicionar', [AdminUserController::class, 'store']);
        Route::post('admin/utilizador/{id}/update', [AdminUserController::class, 'update']);
        Route::get('admin/usuarios/delete/{id}', [AdminUserController::class, 'destroy']);
        Route::get('admin/usuario/perfil', [AdminUserController::class, 'perfilUtilizador']);
        Route::post('admin/usuario/updateSenha/{userId}', [AdminUserController::class, 'updateSenha']);



        // Route::resource('/admin/licencas', 'admin\LicencaController');
        Route::get('/admin/licencas', [LicencaController::class, 'index']);
        Route::resource('/admin/bancos', BancoController::class);
        Route::get('/admin/imprimirBancos', [BancoController::class, 'imprimirBancos']);
        Route::get('/admin/imprimirLicencas', [LicencaController::class, 'imprimirLicencas']);
        Route::get('/admin/imprimirUtilizador', [UserController::class, 'imprimirUtilizador']);
        Route::post('/admin/licencas/adicionar', [LicencaController::class, 'store']);
        Route::post('/admin/licencas/definirValor', [LicencaController::class, 'actualizarValorLicenca']);
        Route::put('/admin/licencas/update/{id}', [LicencaController::class, 'update']);
        Route::get('admin/licencas/deletar/{id}', [LicencaController::class, 'destroy']);


        Route::get('admin/licenca-empresa', [LicencaController::class, 'licencaPorEmpresaIndex']);

        //Coordernadas Bancaria
        Route::resource('admin/coordenadasbancaria', CoordernadaBancariaController::class);

        Route::get('admin/listar-pedidos', [AtivacaoLicencaController::class, 'index']);
        Route::get('admin/listarPedidoLicencas', [AtivacaoLicencaController::class, 'listarPedidoLicencas']);
        Route::get('admin/pedido-licencas/detalhes/{id}', [AtivacaoLicencaController::class, 'detalhes']);
        Route::post('admin/ativar-licenca/{id}', [AtivacaoLicencaController::class, 'ativarLicenca']);
        Route::post('admin/cancelar-licenca/{id}', [AtivacaoLicencaController::class, 'cancelarLicenca']);
        Route::get('/admin/imprimirPedidoLicenca/{pedidoId}', [AtivacaoLicencaController::class, 'imprimirPedidoLicenca']);
        Route::get('/admin/imprimirTodasPedidosLicencas', [AtivacaoLicencaController::class, 'imprimirTodasPedidosLicencas']);

        Route::resource('/admin/cliente-empresa', AdminEmpresaController::class);
        Route::get('/admin/imprimirClientes', [EmpresaController::class, 'imprimirClientes']);
        Route::get('admin/cliente-empresa/detalhes/{id}', [EmpresaController::class, 'detalhes']);
        Route::get('admin/cliente-empresa/{id}/delete', [EmpresaController::class, 'destroy']);

        //Permissions e Roles
        Route::get('admin/funcoes', [RoleController::class, 'index']);
        Route::get('admin/permissoes', [PermissionController::class, 'index']);
        Route::get('admin/funcao/{id}/permissions', [RoleController::class, 'listarPermissoes']);
        Route::get('admin/permission/{permissionId}/role', [PermissionController::class, 'listarRole']);
        Route::get('admin/permission/{permissionId}/delete', [PermissionController::class, 'destroy']);

        Route::get('/admin/taxaIva', [AdminTaxaIvaController::class, 'index']);
        Route::post('/admin/taxaIva/adicionar', [AdminTaxaIvaController::class, 'store']);
        Route::post('/admin/taxaIva/update/{codigo}', [AdminTaxaIvaController::class, 'update']);
        Route::get('/admin/taxaIva/deletar/{id}', [AdminTaxaIvaController::class, 'destroy']);


        Route::get('/admin/motivoIvaListar', [AdminMotivoIvaController::class, 'listar']);
        Route::get('/admin/motivoIva', [AdminMotivoIvaController::class, 'index']);
        Route::post('/admin/motivoIva/adicionar', [AdminMotivoIvaController::class, 'store']);
        Route::post('/admin/motivoIva/update/{id}', [AdminMotivoIvaController::class, 'update']);
        Route::get('/admin/motivoIva/deletar/{id}', [AdminMotivoIvaController::class, 'destroy']);
    });




    // Route::get('/admin/gerarSaft', [GerarSaftController::class, 'index']);
    // Route::get('/admin/gerarSaftXml', [GerarSaftController::class, 'xmlSaft']);
    // // Route::get('/empresa/gerarSaftXml', 'empresa\GerarSaftController@gerarSaft');
    // Route::get('gerarSaftXml', [GerarSaftController::class, 'gerarSaft']);
});



// ======================================================================================================================================
/**
 * ROTAS DO CLIENTE
 */


Route::get("TesteEmail", function () {


    $dado = [
        'email' => 'pauloggjoao@gmail.com',
        'senha' => 'mutue123'
    ];
    JobCreateNewUser::dispatch($dado)->delay(now()->addSecond('5'));
});


Route::get("password/reset", [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.reset');
Route::post("password/reset", [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get("password/reset/{token}", [ResetPasswordController::class, 'showResetForm']);
Route::post("password/reset/{token}", [ResetPasswordController::class, 'reset'])->name("password.update");

Route::group(['middleware' => ['auth:empresa']], function () {

    // Controlo de usuario
    Route::middleware(['updatePassword', 'ControlProduto'])->group(function () {

        //Assinaturas
        // Route::get('empresa/planos-assinaturas', [EmpresaLicencaController::class, 'index'])->name('planosAssinaturas');
        Route::get('empresa/assinaturas', AssinaturaIndexController::class)->name('assinaturas.index');

        Route::middleware(['LicencaTerminado'])->group(function () {

            //Sem Permissão
            Route::get('/empresa/sempermissao', SemPermissaoController::class)->name('semPermissao.index');

            //Produtos
            Route::get('/empresa/produtos', ProdutoIndexController::class)->name('produtos.index');
            Route::get('/empresa/produtos/create', ProdutoCreateController::class)->name('produto.create')->middleware('hasPermission:gerir produtos');
            Route::post('/empresa/produto/store', [ProdutoStoreController::class, 'store'])->name('produto.store')->middleware('hasPermission:gerir produtos');
            Route::get('/empresa/produto/editar/{uuid}', ProdutoUpdateController::class)->name('produto.edit')->middleware('hasPermission:gerir produtos');
            Route::post('/empresa/produto/editar/{uuid}', [ProdutoUpdateController::class, 'update'])->name('produto.update')->middleware('hasPermission:gerir produtos');

            //Recibos
            Route::get('/empresa/recibos', ReciboIndexController::class)->name('recibo.index');
            Route::get('/empresa/recibo/novo', ReciboCreateController::class)->name('recibos.create')->middleware('hasPermission:gerir recibos');

            //Fecho caixa
            Route::get('/empresa/fecho-caixa', FechoCaixaIndexController::class)->name('fechoCaixa.index')->middleware('hasPermission:imprimir_fecho_caixa');

            //Manual utilizador
            Route::get('/manual-utilizador', ManualUtilizadorIndexController::class)->name('manual.index');


            //Nota Credito (Dar saldo ao cliente)
            Route::get('/empresa/notacredito', NotaCreditoIndexController::class)->name('notaCredito.index');
            Route::get('/empresa/notacredito/novo', NotaCreditoCreateController::class)->name('notaCredito.create')->middleware('hasPermission:gerir nota credito');

            //Nota debito (retirar saldo ao cliente)
            Route::get('/empresa/notadebito', NotaDebitoIndexController::class)->name('notaDebito.index');
            Route::get('/empresa/notadebito/novo', NotaDebitoCreateController::class)->name('notaDebito.create')->middleware('hasPermission:gerir nota debito');

            //Nota debito (retirar saldo ao cliente)
            Route::get('/empresa/anulacao/documento', AnulacaoDocumentoIndexController::class)->name('notaCreditoAnulacaoDoc.index');
            Route::get('/empresa/anulacao/documento/factura', AnulacaoDocumentoFacturaCreateController::class)->name('anulacaoDocumentoFactura.create')->middleware('hasPermission:gerir anular documento');
            Route::get('/empresa/anulacao/documento/recibo', AnulacaoDocumentoReciboCreateController::class)->name('anulacaoDocumentoRecibo.create')->middleware('hasPermission:gerir anular documento');


            Route::get('/empresa/retificacao/documento', RetificacaoDocumentoIndexController::class)->name('notaCreditoRetificacaoDoc.index');
            Route::get('/empresa/retificacao/documento/novo', RetificacaoDocumentoCreateController::class)->name('notaCreditoRetificacaoDoc.create')->middleware('hasPermission:gerir rectificar documento');

            // Route::get('/empresa/facturas/anulacao', [OperacaoController::class, 'anulacaoFacturaIndex']);
            Route::get('/empresa/facturas/rectificacao/novo', [OperacaoController::class, 'criarRectificacaoFactura']);

            //Clientes
            Route::get('/empresa/cliente/novo', ClienteCreateController::class)->name('clientes.create')->middleware('hasPermission:gerir clientes');
            Route::get('/empresa/clientes', ClienteIndexController::class)->name('clientes.index');
            Route::get('/empresa/cliente/editar/{clienteId}', ClienteUpdateController::class)->name('clientes.edit')->middleware('hasPermission:gerir clientes');
            Route::get('/empresa/cliente/detalhes/{clienteId}', ClienteShowController::class)->name('clientes.detalhes');
            Route::get('/empresa/cliente/extrato/{uuid}', ClienteExtratoController::class)->name('clientes.extrato');

            //Fabricantes
            Route::get('/empresa/fabricantes', FabricanteIndexController::class)->name('fabricantes.index');
            Route::get('/empresa/fabricante/novo', FabricanteCreateController::class)->name('fabricantes.create')->middleware('hasPermission:gerir fabricantes');
            Route::get('/empresa/fabricante/editar/{fabricanteId}', FabricanteUpdateController::class)->name('fabricantes.edit')->middleware('hasPermission:gerir fabricantes');


            // Armazens
            Route::get('/empresa/armazens', ArmazemIndexController::class)->name('armazens.index');
            Route::get('/empresa/armazem/novo', ArmazemCreateController::class)->name('armazens.create')->middleware('hasPermission:gerir armazens');
            Route::get('/empresa/armazem/editar/{armazemId}', ArmazemUpdateController::class)->name('armazens.edit')->middleware('hasPermission:gerir armazens');

            // Bancos
            Route::get('/empresa/bancos', BancoIndexController::class)->name('bancos.index');
            Route::get('/empresa/banco/novo', BancoCreateController::class)->name('bancos.create')->middleware('hasPermission:gerir bancos');
            Route::get('/empresa/banco/editar/{bancoId}', BancoUpdateController::class)->name('bancos.edit')->middleware('hasPermission:gerir bancos');

            // Forma Pagamento
            Route::get('/empresa/formapagamento', FormaPagamentoIndexController::class)->name('formasPagamento.index');
            // Unidade medidas
            Route::get('/empresa/unidade-medidas', UnidadeMedidaIndexController::class)->name('unidadeMedidas.index');
            Route::get('/empresa/unidade-medida/novo', UnidadeMedidaCreateController::class)->name('unidadeMedidas.create');
            Route::get('/empresa/unidade-medida/editar/{unidadeMedidaId}', UnidadeMedidaUpdateController::class)->name('unidadeMedidas.edit');

            //PERFIS
            Route::get('empresa/perfis', RoleIndexController::class)->name('roles.index');
            Route::get('empresa/perfil/novo', RoleCreateController::class)->name('roles.create');
            Route::get('empresa/perfil/edit/{id}', RoleUpdateController::class)->name('roles.update');
            Route::get('empresa/perfil/{uuid}/permissoes', RolePermissoesIndexController::class)->name('roles.permissao')->middleware('hasPermission:gerir permissões');

            // Route::get('empresa/home', [EmpresaHomeController::class, 'index']);
            Route::get('empresa/usuarios', UsuarioIndexController::class)->name('users.index');
            Route::get('empresa/usuario/novo', UsuarioCreateController::class)->name('users.create')->middleware('hasPermission:gerir utilizadores');
            Route::get('empresa/usuario/edit/{uuid}', UsuarioUpdateController::class)->name('users.edit')->middleware('hasPermission:gerir utilizadores');
            Route::get('empresa/usuario/{uuid}/permissoes', UsuarioPermissoesIndexontroller::class)->name('users.permissions');


            Route::get('empresa/funcao/{id}/permissions', [EmpresaRoleController::class, 'listarPermissoes']);
            Route::get('empresa/permission/{permissionId}/role', [EmpresaPermissionController::class, 'listarRole']);

            //Fornecedor
            Route::get('/empresa/fornecedores', FornecedorIndexController::class)->name('fornecedores.index');
            Route::get('/empresa/fornecedor/novo', FornecedorCreateController::class)->name('fornecedores.create')->middleware('hasPermission:gerir fornecedores');
            Route::get('/empresa/fornecedor/editar/{fornecedorId}', FornecedorUpdateController::class)->name('fornecedores.edit')->middleware('hasPermission:gerir fornecedores');
            Route::get('/empresa/fornecedor/detalhes/{fornecedorId}', FornecedorShowController::class)->name('fornecedores.detalhes');

            //Empresa
            Route::get('empresa/configuracao', EmpresaUpdateController::class)->name('empresa.edit')->middleware('hasPermission:gerir empresa');
            // Route::get('empresa/configuracao', [EmpresaController::class, 'edit'])->name('empresa.edit');

            //Marcas
            Route::get('/empresa/marcas', MarcaIndexController::class)->name('marcas.index');
            Route::get('/empresa/marca/novo', MarcaCreateController::class)->name('marcas.create')->middleware('hasPermission:gerir marcas');
            Route::get('/empresa/marca/editar/{marcaId}', MarcaUpdateController::class)->name('marcas.edit')->middleware('hasPermission:gerir marcas');
            //Categorias
            Route::get('/empresa/categorias', CategoriaIndexController::class)->name('categorias.index');
            Route::get('/empresa/categoria/novo', CategoriaCreateController::class)->name('categorias.create')->middleware('hasPermission:gerir categoria');
            Route::get('/empresa/categoria/editar/{categoriaId}', CategoriaUpdateController::class)->name('categorias.edit')->middleware('hasPermission:gerir categoria');
            Route::get('/empresa/categoria/addsub/{categoriaId}', CategoriaUpdateSubCategoriaController::class)->name('categorias.addSubCategoria')->middleware('hasPermission:gerir categoria');


            // Permissoes
            Route::get('/empresa/permissoes', PermissaoIndexController::class)->name('permissoes.index');

            // Modelos documentos
            Route::get('empresa/modelo-documentos', ModeloDocumentoController::class)->name('modeloDocumento.index')->middleware('hasPermission:editar modelo documento');

            // Facturas
            Route::get('empresa/facturas-proformas', FacturaProformaIndexController::class)->name('facturasProformaIndex')->middleware('hasPermission:converter proforma');

            // Route::post('/empresa/produto/store', [ProdutoStoreController::class, 'store'])->name('produto.store')->middleware('hasPermission:gerir produtos');
            // Route::get('/empresa/produto/editar/{uuid}', ProdutoShowController::class)->name('produto.edit')->middleware('hasPermission:gerir produtos');
            // Route::post('/empresa/produto/editar/{uuid}', [ProdutoUpdateController::class, 'update'])->name('produto.update')->middleware('hasPermission:gerir produtos');


            //Centro custo
            Route::get('empresa/centro-custos', CentroCustoIndexController::class)->name('centroCusto.index');
            Route::get('empresa/centro/custos', CentroCustoRelatorioIndexController::class)->name('centroCustosIndex');
            // Route::get('empresa/centro/custos', [CentroCustoController::class, 'centroCustosIndex'])->name('centroCustosIndex');
            Route::get('empresa/centro/custos/novo', CentroCustoCreateController::class)->name('centroCusto.create')->middleware('hasPermission:gerir centro de custo');
            Route::get('empresa/centro/custo/editar/{uuid}', CentroCustoUpdateController::class)->name('centroCusto.update')->middleware('hasPermission:gerir centro de custo');
            // Route::get('empresa/centro/custos/editar/{uuid}', [CentroCustoController::class, 'edit'])->name('centroCusto.edit');
            // Route::get('empresa/centro/custos/novo', [CentroCustoController::class, 'create'])->name('centroCusto.create');
            // Route::post('empresa/centro/custos/novo', [CentroCustoController::class, 'store'])->name('centroCusto.store');
            // Route::put('empresa/centro/custos/editar/{uuid}', [CentroCustoController::class, 'update'])->name('centroCusto.update');

            //Minhas licenças
            Route::get('empresa/minhas-licencas', MinhaLicencaController::class)->name('minhasLicencas');
            // Route::get('empresa/minhas-licencas', [EmpresaLicencaController::class, 'minhasLicencas']);


            //Vendas
            Route::get('/empresa/vendas-diaria', VendasDiariaIndexController::class)->name('indexVendaDiaria');
            Route::get('/empresa/vendas-mensal', VendasMensalIndexController::class)->name('indexVendaMensal');


            //entrada estoque
            Route::get('/empresa/produtos/entrada', EntradaProdutoIndexController::class)->name('entradasProdutosIndex');
            Route::get('/empresa/produtos/entrada/novo', EntradaProdutoCreateController::class)->name('entradasProdutosCreate');
            // Route::get('/empresa/produtos/entrada', [OperacaoController::class, 'entradaProdutoStockIndex']);

            // Route::get('/empresa/produtos/entrada/novo', [OperacaoController::class, 'entradaProdutoStockNovo'])->name('entradasProdutosCreate')->middleware('hasPermission:gerir entrada produto');
            Route::get('/empresa/produto/actualizar-stock', [ExistenciaStockController::class, 'index']);


            // Route::get('/empresa/vendas-mensal', [VendaController::class, 'indexVendaMensal']);

            // Route::get('/empresa/vendas-diaria', [VendaController::class, 'indexVendaDiaria']);


            //Relatórios
            Route::post('empresa/centro/custo/{uuid}/relatorio-stock/imprimir', [RelatorioController::class, 'printRelatorioStock'])->name('relatorioEstoque');
            Route::get('empresa/centro/custo/{uuid}/relatorio-existenciastock/imprimir', [RelatorioController::class, 'printRelatorioExistenciaStock'])->name('relatorioExistenciaStock');
            Route::post('empresa/centro/custo/{uuid}/relatorio-existenciavenda/imprimir', [RelatorioController::class, 'printRelatorioVenda'])->name('relatorioVenda');
            // Route::get('empresa/centro/custo/{uuid}/relatorios', RelatorioController::class)->name('relatorio.index')->middleware('hasPermission:visualizar relatorio por centro custo');;



            Route::get('empresa/relatorios', RelatorioController::class)->name('relatorio.index')->middleware('hasPermission:visualizar relatorios');;





            Route::get('empresa/vendas', [PdvController::class, 'index'])->name('empresa.vendas');
            Route::get('empresa/vendas/listarProdutosVendas', [ProdutoController::class, 'listarProdutosVendas']);
            Route::get('empresa/vendas/listarDocumentoVenda', [TipoDocumentoController::class, 'listarDocumentoVenda']);
            Route::get('empresa/vendas/listarFormaPagamentoVendas', [FormaPagamentoController::class, 'listarFormaPagamentoVendas']);
            Route::get('/empresa/vendas/listarClientesInputFactura', [ClienteController::class, 'listarClientesInputFactura']);
            Route::get('empresa/vendas/pegarClienteDiverso', [ClienteController::class, 'pegarClienteDiverso']);
            Route::post('empresa/vendas/finalizarVenda', [FinalizarVendaController::class, 'store']);
            Route::get('/imprimirFactura', [FacturaController::class, 'imprimirFactura']);
            Route::get('/imprimirFacturaPdv1', [FacturaController::class, 'imprimirFacturaPdv1']);
            Route::get('/reimprimirFactura', [FacturaController::class, 'reimprimirFactura']);
            Route::get('/imprimirFacturaTicket', [FacturaController::class, 'imprimirFacturaTicket']);
            Route::post('empresa/fechocaixaVenda/imprimir', [FechoCaixaController::class, 'imprimirFechoCaixaVenda']);

            Route::post('empresa/pedido-licenca/{id}', [EmpresaLicencaController::class, 'pedidoAtivacaoLicenca']);
            Route::get('/empresa/planos-assinaturas/pegar-dependecias', [EmpresaLicencaController::class, 'pegarDependencias']);

            // Route::get('empresa/planos-assinaturas', 'empresa\LicencaController@index');
            Route::post('/empresa/planos-assinaturas/salvar-factura', [LicencaController::class, 'salvarPedidoFactura']);

            Route::post('/empresa/planos-assinaturas/salvar-pagamento', [LicencaController::class, 'salvarPagamento']);
            Route::get('/empresa/planos-assinaturas/imprimir-factura/{id}', [LicencaController::class, 'imprimirFactura']);
            Route::get('/empresa/planos-assinaturas/imprimir-recibo-pagamento/{id}/{tipoFactura}', [LicencaController::class, 'imprimirReciboPagamento']);
            Route::get('/empresa/planos-assinaturas/buscar-referencia-factura/{faturaRereference}', [LicencaController::class, 'buscarReferenciaFactura']);

            //Configurações
            Route::get('empresa/definir-parametros', [EmpresaConfiguracaoController::class, 'index'])->middleware('hasPermission:definir parametros');
            Route::post('empresa/impressao/editar', [EmpresaConfiguracaoController::class, 'show']);
            Route::post('empresa/retencao/atualizarRetencao', [EmpresaConfiguracaoController::class, 'actualizarRetencao']);
            Route::post('empresa/desconto/atualizarDesconto', [EmpresaConfiguracaoController::class, 'atualizarDesconto']);
            Route::post('empresa/impressao/adicionar', [EmpresaConfiguracaoController::class, 'atualizarTipoImpressao']);
            Route::post('empresa/viaImpressao/adicionar', [EmpresaConfiguracaoController::class, 'atualizarNumeroViaImpressao']);


            Route::post('empresa/alterarDiasVencimentoFactura', [EmpresaConfiguracaoController::class, 'alterarDiasVencimentoFactura']);
            Route::post('empresa/alterarDiasVencimentoFtProforma', [EmpresaConfiguracaoController::class, 'alterarDiasVencimentoFtProforma']);
            Route::post('empresa/alterarSerieDocumento', [EmpresaConfiguracaoController::class, 'alterarSerieDocumento']);
            Route::post('empresa/alterarObservacaoFactura', [EmpresaConfiguracaoController::class, 'alterarObservacaoFactura']);


            //Fecho de caixa
            Route::post('empresa/fechocaixa/imprimir', [FechoCaixaController::class, 'imprimirFechoCaixa']);

            //notificações
            Route::get('notifications', [EmpresaNotificacaoController::class, 'notifications']);
            Route::get('empresa/notificationsAll', [EmpresaNotificacaoController::class, 'notificationsAll']);
            Route::get('empresa/listar-notificacoes', [EmpresaNotificacaoController::class, 'listarNotificacoes']);
            Route::put('empresa/notificationsRead', [EmpresaNotificacaoController::class, 'markAsRead']);
            Route::get('empresa/notifications/deletar/{id}', [EmpresaNotificacaoController::class, 'deletar']);

            //Página inicial do cliente
            Route::put('empresa/usuarios/{id}/update', [UserController::class, 'update']);
            Route::get('empresa/usuarios/{id}/delete', [UserController::class, 'destroy']);
            Route::get('empresa/usuario/perfil', [UserController::class, 'perfilUtilizador']);
            Route::post('empresa/usuario/updateSenha/{userId}', [UserController::class, 'updateSenha']);
            Route::get('/fichaCadastro', [UserController::class, 'visualizarFichaCadastro']);


            Route::post('empresa/configuracao/update/{id}', [EmpresaController::class, 'update'])->name('empresa.update');

            Route::post('empresa/setar-modelo-documento', [EmpresaConfiguracaoController::class, 'setarModeloDocumento']);

            Route::get('/empresa/pagamento/fornecedor', [FornecedorController::class, 'pagamentoFacturaFornecedor'])->middleware('hasPermission:gerir pagamento fornecedor');

            Route::get('/empresa/imprimirPagamentoFornecedor/{pagamentoId}/{viaImpressao}', [FornecedorController::class, 'imprimirPagamentoFornecedor']);
            Route::post('/empresa/pagamentoFacturaFornecedor', [FornecedorController::class, 'pagamentoFornecedor']);
            Route::get('/empresa/buscarDividaRestante/{entradaProdutoId}/{fornecedorId}', [FornecedorController::class, 'buscarDividaRestante']);
            Route::get('/empresa/listarFornecedores', [FornecedorController::class, 'listarFornecedores']);
            Route::get('/empresa/listarFacturasFornecedores/{fornecedorId}', [FornecedorController::class, 'listarFacturasFornecedores']);
            Route::get('/empresa/pagamentoEfectuadosFacturaFornecedor', [FornecedorController::class, 'listarPagamentosFacturasFornecedores']);

            Route::get('/empresa/fornecedores/adicionar', [FornecedorController::class, 'create']);
            Route::post('/empresa/fornecedores/adicionar', [FornecedorController::class, 'store']);
            Route::get('/empresa/fornecedorImprimir', [FornecedorController::class, 'imprimirFornecedores']);
            Route::get('/empresa/fornecedores/detalhes/{id}', [FornecedorController::class, 'detalhes']);
            Route::get('/empresa/fornecedores/editar/{id}', [FornecedorController::class, 'edit']);
            Route::post('empresa/fornecedores/update/{id}', [FornecedorController::class, 'update']);
            Route::get('empresa/fornecedores/deletar/{id}', [FornecedorController::class, 'destroy']);
            Route::get('/empresa/imprimir/fornecedores', [ReportController::class, 'imprimirFornecedores']);

            Route::get('/empresa/clientes/create', [ClienteController::class, 'create']);
            Route::post('/empresa/clientes/adicionar', [ClienteController::class, 'store']);
            Route::post('/empresa/cliente/imprimirExtratoConta', [ClienteController::class, 'imprimirExtratoConta']);
            Route::get('/empresa/clientes/detalhes/{id}', [ClienteController::class, 'detalhes']);
            Route::get('/empresa/clientes/editar/{id}', [ClienteController::class, 'edit']);
            Route::post('/empresa/clientes/update/{id}', [ClienteController::class, 'update']);
            Route::get('/empresa/clientes/deletar/{id}', [ClienteController::class, 'destroy']);
            Route::get('/empresa/clientes/{query}', [ClienteController::class, 'show']);
            Route::get('/empresa/pegar-dependecias', [ClienteController::class, 'pegarDependencias']);
            Route::get('/empresa/clientes/saldoActual/{idCliente}', [ClienteController::class, 'PegarSaldoCliente']);


            // ROTAS USADO NO VUE
            Route::get('/empresa/listarClienteFacturacao', [ClienteController::class, 'listarClientes']);
            Route::get('/empresa/clientes-filtro/{status_id}/{pais_id}', [ClienteController::class, 'listarClienteFiltro']);
            Route::get('/empresa/imprimir-clientes', [ClienteController::class, 'imprimirClientes']);

            // Gestores
            Route::get('/empresa/gestores', [GestorController::class, 'index']);
            Route::post('/empresa/gestores/adicionar', [GestorController::class, 'store']);
            Route::post('/empresa/gestores/update/{id}', [GestorController::class, 'update']);
            Route::get('/empresa/gestores/deletar/{id}', [GestorController::class, 'destroy']);
            Route::get('/empresa/gestores/pegar-dependecias', [GestorController::class, 'pegarDependencias']);
            Route::get('/empresa/imprimir/gestores', [ReportController::class, 'imprimirGestores']);

            Route::get('/empresa/armazens/pegar-dependecias', [ArmazenController::class, 'pegarDependencias']);
            // Categorias
            Route::post('/empresa/categorias/adicionar', [CategoriaController::class, 'store']);
            Route::post('/empresa/categorias/update/{id}', [CategoriaController::class, 'update']);
            Route::get('/empresa/categorias/deletar/{id}', [CategoriaController::class, 'destroy']);
            Route::get('/empresa/categorias/pegar-dependecias', [CategoriaController::class, 'pegarDependencias']);
            Route::get('/empresa/imprimir/categorias', [CategoriaController::class, 'imprimirCategorias']);

            // Marcas
            Route::post('/empresa/marcas/adicionar', [MarcaController::class, 'store']);
            Route::post('/empresa/marcas/update/{id}', [MarcaController::class, 'update']);
            Route::get('/empresa/marcas/deletar/{id}', [MarcaController::class, 'destroy']);
            Route::get('/empresa/marcas/pegar-dependecias', [MarcaController::class, 'pegarDependencias']);
            Route::get('/empresa/imprimir/marcas', [MarcaController::class, 'imprimirMarcas']);

            Route::get('/empresa/unidades/pegar-dependecias', [UnidadeController::class, 'pegarDependencias']);

            // Classes de Bem
            Route::get('/empresa/classes', [ClasseController::class, 'index']);
            Route::post('/empresa/classes/adicionar', [ClasseController::class, 'store']);
            Route::post('/empresa/classes/update/{id}', [ClasseController::class, 'update']);
            Route::get('/empresa/classes/deletar/{id}', [ClasseController::class, 'destroy']);
            Route::get('/empresa/classes/pegar-dependecias', [ClasseController::class, 'pegarDependencias']);
            Route::get('/empresa/imprimir/classes', [ClasseController::class, 'imprimirClasses']);


            // Forma de Pagamento
            Route::get('/empresa/listarFormaPagamento', [FormaPagamentoController::class, 'listarFormaPagamento']);
            Route::post('/empresa/formapagamento/adicionar', [FormaPagamentoController::class, 'store']);
            Route::post('/empresa/formapagamento/update/{id}', [FormaPagamentoController::class, 'update']);
            Route::get('/empresa/formapagamento/deletar/{id}', [FormaPagamentoController::class, 'destroy']);
            Route::get('/empresa/formapagamento/pegar-dependecias', [FormaPagamentoController::class, 'pegarDependencias']);
            Route::get('/empresa/imprimir/formapagamento', [FormaPagamentoController::class, 'imprimirFormaPagamento']);

            // Produtos
            Route::get('/empresa/produtos-mais-vendidos', [ProdutoController::class, 'indexMaisVendidos'])->middleware('hasPermission:visualizar produtos mais vendidos');
            Route::get('empresa/listarProdutos', [ProdutoController::class, 'listarProdutos']);
            Route::post('/empresa/produtos/editar/{id}', [ProdutoController::class, 'update']);

            //centro de custo
            Route::get('/centro-de-custo', [EmpresaController::class, 'centrodeCusto']);

            Route::get('/empresa/produtos/deletar/{id}', 'empresa\ProdutoController@destroy');

            Route::post('/empresa/produtos/adicionar', [ProdutoController::class . 'store']);
            Route::get('/empresa/produtos/listarArmazens', [ProdutoController::class, 'listarArmazens']);
            Route::get('/empresa/pegar-dependecias', [ProdutoController::class, 'pegarDependencias']);
            Route::get('/empresa/imprimir-produtos', [ProdutoController::class, 'imprimirProdutos']);

            //LISTAR PRODUTOS EM ESTOQUE
            Route::get('/empresa/produtos/stock', [ProdutoController::class, 'stock'])->middleware('hasPermission:visualizar existencia estoque produto');;
            Route::get('/empresa/produtos/quantidade/critica', [ProdutoController::class, 'listar_Quantidade_critica']);

            Route::get('/empresa/categorias/adicionar', [CategoriaController::class, 'create']);
            Route::post('/empresa/categorias/adicionar', [CategoriaController::class, 'store']);


            Route::get('empresa/facturacao', [FacturacaoController::class, 'index']);
            Route::put('empresa/facturacao/produto/editar', [FacturacaoController::class, 'editarProduto']);
            Route::get('empresa/facturacao/imprimir-lista-vendas', [FacturacaoController::class, 'imprimirListaVenda']);
            Route::get('empresa/facturacao/criar', [FacturacaoController::class, 'create']);
            Route::post('empresa/facturacao/salvar', [FacturacaoController::class, 'store']);
            Route::get('empresa/facturacao/produtos/{armazen_id}', [FacturacaoController::class, 'listarProdutos']);
            Route::get('empresa/facturacao/produtoQtdExistenciaStock/{id}/{quant}', [FacturacaoController::class, 'listarQtdProdutoStock']);

            Route::get('empresa/facturacao/cliente_default', [FacturacaoController::class, 'listarClienteDefault']);

            //Listar facturas
            Route::get('empresa/facturas', FacturasIndexController::class)->name('facturas.index');
            Route::get('empresa/listarFacturas', [FacturacaoController::class, 'listarFacturasApi']);
            Route::get('empresa/facturasCliente/{clienteId}', [FacturaController::class, 'listarFacturasPorCliente']);
            Route::get('empresa/facturas-licencas', [FacturaController::class, 'facturasLicencasIndex']);
            Route::get('empresa/recibos-facturas-licenca', [FacturaController::class, 'reciboFacturaLincencaIndex']);
            Route::get('empresa/recibosFacturasLicenca/{reciboFacturaLicencaId}', [FacturaController::class, 'imprimirReciboLicenca']);
            Route::get('empresa/searchFacturas', [FacturaController::class, 'searchFacturas']);
            Route::get('empresa/searchRecibos', [FacturaController::class, 'searchRecibos']);
            Route::post('empresa/converterFacturaProforma/salvar', [FacturaController::class, 'converterFacturaProforma']);

            Route::get('empresa/facturacao/imprimir-factura/{id}', [FacturacaoController::class, 'reimprimirFactura']);
            Route::get('empresa/facturacao/imprimir-factura/{id}/{tipoFactura}', [FacturacaoController::class, 'imprimirFactura']);
            Route::get('empresa/factura/imprimir-factura-anulada/{id}', [FacturacaoController::class, 'imprimirFacturaAnulada']);

            Route::get('empresa/facturacao/formaPagamentos', [FacturacaoController::class, 'listarFormaPagamentos']);
            Route::get('empresa/facturacao/armazens', [FacturacaoController::class, 'listarArmazens']);


            //todas as rotas de operaçoes
            Route::get('empresa/facturas/operacao-deposito-recibo', [OperacaoController::class, 'depositoReciboIndex']);
            Route::get('empresa/imprimirRecibo/{id}', [OperacaoController::class, 'imprimirRecibo']);
            Route::get('empresa/imprimirTodosRecibos', [OperacaoController::class, 'imprimirTodasRecibos']);

            Route::get('empresa/facturas/recibo/novo', [OperacaoController::class, 'createRecibo']);
            Route::get('/empresa/recibo/ListarClientesComFacturasRecibo', [OperacaoController::class, 'ListarClientesComFacturasRecibo']);
            Route::get('/empresa/recibo/ListarClientesComFacturas', [OperacaoController::class, 'ListarClientesComFacturas']);
            Route::get('/empresa/recibo/verificaAplicacaoRetencaoRecibo/{facturaId}', [OperacaoController::class, 'verificaAplicacaoRetencaoRecibo']);

            Route::get('/empresa/comparaDataDocumento', [OperacaoController::class, 'comparaDataDocumentoAnteriorComAtual']);

            Route::get('empresa/factura/{id}', [OperacaoController::class, 'listarFactura']);

            //rotas de vendas por produtos, diaria, mensal
            Route::get('/empresa/vendas-produtos', [VendaController::class, 'indexVendaProduto']);
            Route::get('/empresa/vendas-produto/{id}', [VendaController::class, 'imprimirVendasPorProdutos']);
            Route::get('/empresa/relatorios-vendas', [VendaController::class, 'indexRelatoriosVendas']);
            Route::get('/empresa/listarVendasMensal', [HomeController::class, 'listarVendasMensal']);
            Route::get('/empresa/movimento/diario', [VendaController::class, 'movimentoDiario']);
            Route::post('/empresa/imprimirMovimentoDiario', [VendaController::class, 'imprimirMovimentoDiario']);
            Route::get('/empresa/imprimirRelatorioDiario', [VendaController::class, 'imprimirRelatorioDiario']);
            Route::get('/empresa/imprimirRelatorioMensal', [VendaController::class, 'imprimirRelatorioMensal']);
            Route::get('/empresa/imprimirRelatorioAnual', [VendaController::class, 'imprimirRelatorioAnual']);
            Route::get('/empresa/imprimirTodosRelatorioDiarioPorFuncionario', [VendaController::class, 'imprimirTodosRelatorioDiarioPorFuncionario']);
            Route::get('/empresa/imprimirTodosRelatorioDiario', [VendaController::class, 'imprimirTodosRelatorioDiarioPorFuncionario']);
            Route::get('/empresa/imprimirRelatorioAnualTodoFuncioario', [VendaController::class, 'imprimirRelatorioAnualTodoFuncioario']);
            Route::get('/empresa/imprimirRelatorioMensalTodoFuncionario', [VendaController::class, 'imprimirRelatorioMensalTodoFuncionario']);

            Route::get('/empresa/facturacao-diaria', [VendaController::class, 'listaFacturacaoDiaria']);
            Route::get('/empresa/facturacao-diaria/{data}', [VendaController::class, 'imprimirVendasDiaria']);
            Route::get('/empresa/facturas-mensal', [VendaController::class, 'listaFacturacaoMensal']);
            Route::get('/empresa/facturas-mensalImprimir', [VendaController::class, 'imprimirVendasMensal']);

            //todas as rotas de operaçoes
            Route::get('/empresa/facturas/operacao-deposito-recibo', [OperacaoController::class, 'depositoReciboIndex']);

            Route::get('/empresa/taxaIvaListar', [TaxaIvaController::class, 'listarTaxas']);
            Route::get('/empresa/taxaIva', [TaxaIvaController::class, 'index']);
            Route::post('/empresa/taxaIva/adicionar', [TaxaIvaController::class, 'store']);
            Route::post('/empresa/taxaIva/update/{codigo}', [TaxaIvaController::class, 'update']);
            Route::get('/empresa/taxaIva/deletar/{id}', [TaxaIvaController::class, 'destroy']);

            Route::get('/empresa/motivoIva', [MotivoIvaController::class, 'index']);
            Route::post('/empresa/motivoIva/adicionar', [MotivoIvaController::class, 'store']);
            Route::post('/empresa/motivoIva/update/{id}', [MotivoIvaController::class, 'update']);
            Route::get('/empresa/motivoIva/deletar/{id}', [MotivoIvaController::class, 'destroy']);
            Route::get('/empresa/motivoIvaListar/{regimeEmpresa}', [MotivoIvaController::class, 'listar']);

            //Gerar Saft
            Route::get('/empresa/gerarSaft', GerarSaftController::class)->middleware('hasPermission:gerar saft');
            Route::get('/empresa/gerarSaftXml', [GerarSaftController::class, 'gerarSaft'])->middleware('hasPermission:gerar saft');
            //STOCK

            Route::post('empresa/entradaStock', [StockController::class, 'entradaStock']);
            Route::get('empresa/imprimirEntradaStock/{entradaId}', [StockController::class, 'imprimirEntradaStock']);
            Route::get('empresa/produtos/existenciaStock', [ExistenciaStockController::class, 'listarExistenciaStock']);
            Route::get('empresa/produtos/actualizar/novo', [ExistenciaStockController::class, 'actualizarProdutoStockNovo'])->middleware('hasPermission:gerir actualizar estoque');
            Route::get('empresa/produtos/imprimirActualizacaoStock/{actualizaStockId}', [ExistenciaStockController::class, 'imprimirActualizacaoStock']);
            Route::get('empresa/produtos/existenciaStock/{produtoId}/{armazemId}', [ExistenciaStockController::class, 'listarProdutoExistenciaStock']);
            Route::get('empresa/produtos/imprimir/existenciaStock', [ExistenciaStockController::class, 'imprimirExistenciaStock']);
            Route::get('empresa/produtos/imprimir/existenciaStock/{existenciaId}', [ExistenciaStockController::class, 'imprimirExistenciaStocksPorId']);
            Route::post('empresa/produtos/actualizarStock', [ExistenciaStockController::class, 'actualizarStock']);
            Route::get('empresa/produtos/transferencia', [StockController::class, 'transferenciaIndex']);
            Route::get('empresa/produtos/transferencia/novo', [StockController::class, 'transferenciaNovo'])->middleware('hasPermission:gerir transferir produto');
            Route::post('empresa/produtos/transferencia/salvar', [StockController::class, 'transferenciaSalvar']);
            Route::get('empresa/produtos/transferencia/imprimir/{id}', [StockController::class, 'transferenciaImprimir']);


            //forma de pagamento
            Route::get('/empresa/tipoFormaPagamentos', [PagamentoController::class, 'listarTipoFormaPagamentos']);
            Route::get('/empresa/formasPagamentosGeral', [PagamentoController::class, 'listarFormasPagamentosGeral']);

            Route::get('/empresa/roles-permissions', [RolesPermissionController::class, 'rolesPermissions']);

            //Emitir recibos
            Route::post('/empresa/recibo/salvar', [OperacaoController::class, 'emitirRecibo']);

            //Operações
            Route::get('/empresa/facturas/rectificacao', [OperacaoController::class, 'rectificacaoFacturaIndex']);
            Route::get('/empresa/facturas/anulacao', [OperacaoController::class, 'anulacaoFacturaIndex']);
            Route::get('/empresa/facturas/anulacao/novo', [OperacaoController::class, 'criarAnulacaoFactura']);
            Route::get('/empresa/factura/anulacacao/listarTipoDocumentos', [OperacaoController::class, 'listarTipoDocumentos']);
            Route::get('/empresa/factura/anulacacao/listarFacturasRefDocumentoEcliente/{TipoDoc}/{idCliente}', [OperacaoController::class, 'listarFacturasRefDocumentoEcliente']);

            //Anulação de recibos
            Route::get('/empresa/recibos/anulacao/novo', [OperacaoController::class, 'criarAnulacaoRecibo']);
            Route::post('empresa/setar-modelo-documento', [EmpresaConfiguracaoController::class, 'setarModeloDocumento']);

            Route::get('/empresa/anulacacao/listarReciboRefCliente/{idCliente}', [OperacaoController::class, 'listarRecibosRecCliente']);

            Route::post('/empresa/documentoAnuladoFacturas/salvar', [OperacaoController::class, 'salvarDocumentoAnuladoFacturas']);
            Route::post('/empresa/documentoAnuladoRecibos/salvar', [OperacaoController::class, 'salvarDocumentoAnuladoRecibos']);
            Route::get('/empresa/imprimirDocumentoAnuladoFacturas/{facturaId}', [OperacaoController::class, 'imprimirDocumentoAnuladoFacturas']);
            Route::get('/empresa/imprimirDocumentoAnuladoRecibos/{reciboId}', [OperacaoController::class, 'imprimirDocumentoAnuladoRecibos']);

            //Inventarios
            Route::get('/empresa/inventarios', [InventarioController::class, 'index'])->middleware('hasPermission:gerir inventario');
            Route::post('/empresa/inventario/adicionar', [InventarioController::class, 'store']);
            Route::get('/empresa/inventario/imprimir/{inventarioId}', [InventarioController::class, 'imprimirInventario']);

            //documento retificados
            Route::post('/empresa/salvarFacturasRecitificadas', [FacturaController::class, 'salvarFacturasRecitificadas']);
            Route::get('/empresa/imprimirDocumentoRetificado/{docRetificadoId}/{idFactura}', [OperacaoController::class, 'imprimirDocumentoRetificado']);

            Route::get('/empresa/documentosRectificados/clientes', [OperacaoController::class, 'ListarClientesFacturasComFaturaRecibo']);
            Route::get('/empresa/listarFacturasAoSelecionarTipoDocumento/{idCliente}/{tipoDocumento}', [OperacaoController::class, 'ListarFacturasAoSelecionarDocumento']);

            //Emitir notas de credito e debito

            Route::get('/empresa/notaCreditoDebitoListarclientes', [OperacaoController::class, 'listarClientes']);

            Route::get('/empresa/imprimirNotaCredito/{idNotaCredito}', [OperacaoController::class, 'imprimirNotaCredito']);
            Route::get('/empresa/imprimirTodasNotaCredito', [OperacaoController::class, 'imprimirTodasNotaCredito']);

            Route::post('/empresa/notaCreditoSalvar', [OperacaoController::class, 'salvarNotaCredito']);
            Route::post('/empresa/notaDebitoSalvar', [OperacaoController::class, 'salvarNotaDebito']);
            Route::get('/empresa/imprimirNotaDebito/{idNotaDebito}', [OperacaoController::class, 'imprimirNotaDebito']);
            Route::get('/empresa/imprimirTodasNotaDebito', [OperacaoController::class, 'imprimirTodasNotaDebito']);
            Route::get('/empresa/listarNotaCredito', [OperacaoController::class, 'listarNotaCredito']);

            //upload img empresa
            Route::post('/empresa/update_logomarca/{id}', [EmpresaController::class, 'alterarLogotipo']);
        });
    });
    Route::middleware(['ControlProduto'])->group(function () {
        Route::get('empresa/home', [EmpresaHomeController::class, 'index'])->name('funcionario/home');
    });
    Route::get('/empresa/infoDashboard', [AuthController::class, 'infoDashboard']);
    Route::post('/empresa/update_senha/{id}', [UserController::class, 'alterarPassword']);
    Route::get('empresa/perfil', [AuthController::class, 'perfil']);
});


//Route::get('/empresa/{vue}', 'SpaController@index')->where('vue', '.*');
