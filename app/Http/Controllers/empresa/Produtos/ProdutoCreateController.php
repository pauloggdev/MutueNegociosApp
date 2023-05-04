<?php

namespace App\Http\Controllers\empresa\Produtos;

use App\Models\empresa\Armazen;
use App\Models\empresa\Categoria;
use App\Models\empresa\MotivoIsencao;
use App\Models\empresa\TipoTaxa;
use App\Repositories\Empresa\ArmazemRepository;
use App\Repositories\Empresa\CategoriaRepository;
use App\Repositories\Empresa\MotivoIsencaoRepository;
use App\Repositories\Empresa\TaxaRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Keygen\Keygen;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Storage;

class ProdutoCreateController extends Component
{

    use VerificaSeEmpresaTipoAdmin;
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use WithFileUploads;
    use LivewireAlert;

    public $produto;
    public $desabledStock = false;
    public $margemLucro;
    public $motivos;
    public $taxas;
    public $categorias;
    public $armazens;
    public $status;
    public $unidades;
    public $fabricantes;
    protected $motivoIsencaoRepository;
    protected $taxaRepository;
    protected $categoriaRepository;
    protected $armazemRepository;


    public function mount()
    {

        $this->motivoIsencaoRepository = new MotivoIsencaoRepository(new MotivoIsencao());
        $this->taxaRepository = new TaxaRepository(new TipoTaxa());
        $this->categoriaRepository = new CategoriaRepository(new Categoria());
        $this->armazemRepository = new ArmazemRepository(new Armazen());

        $this->motivos =  $this->motivoIsencaoRepository->listarMotivosPelaTaxa(1);
        $this->taxas = $this->taxaRepository->listarTaxas();
        $this->categorias = $this->categoriaRepository->getCategoriasComDiversos();
        $this->armazens = $this->armazemRepository->getArmazensComDiversos();
        $this->status = DB::table('status_gerais')->orderBy('id', 'asc')->get();
        $this->unidades = DB::table('unidade_medidas')->where('empresa_id', auth()->user()->empresa_id)->orderBy('id', 'asc')->get();
        $this->fabricantes = DB::table('fabricantes')->where('empresa_id', auth()->user()->empresa_id)->orderBy('id', 'asc')->get();

        $this->setarValor();
    }
    public function setarValor()
    {

        $this->produto['designacao'] = NULL;
        $this->produto['preco_venda'] = NULL;
        $this->produto['preco_compra'] = NULL;
        $this->produto['venda_online'] = false;
        $this->produto['imagens'] = [];
        $this->produto['marca_id'] = NULL;
        $this->produto['classe_id'] = NULL;
        $this->produto['canal_id'] = 2;
        $this->produto['quantidade_minima'] = 0;
        $this->produto['quantidade_critica'] = 0;
        $this->produto['categoria_id'] = 1;
        $this->produto['status_id'] = 1;
        $this->produto['stocavel'] = "Sim";
        $this->produto['quantidade'] = 0;
        $this->produto['armazem_id'] = $this->armazens[0]->id;
        $this->produto['unidade_medida_id'] = $this->unidades[0]->id;
        $this->produto['fabricante_id'] = $this->fabricantes[0]->id;
        $this->produto['codigo_taxa'] = 1;
        $this->produto['motivo_isencao_id'] = 8;
        $this->produto['imagem_produto'] = null;
        $this->produto['margemLucro'] = 0;
    }

    public function render()
    {
        $this->unidades = DB::table('unidade_medidas')->where('empresa_id', auth()->user()->empresa_id)->orderBy('id', 'asc')->get();
        $this->fabricantes = DB::table('fabricantes')->where('empresa_id', auth()->user()->empresa_id)->orderBy('id', 'asc')->get();

        return view('empresa.produtos.create');
    }

    public function updatedProdutoCodigoTaxa($taxaId)
    {
        $motivoIsencaoRepository = new MotivoIsencaoRepository(new MotivoIsencao());
        $this->motivos =  $motivoIsencaoRepository->listarMotivosPelaTaxa($taxaId);
    }

    public function calcularVenda()
    {
        if ($this->preco_venda) {
            $this->margemLucro =  0;
        }
    }
    public function updatedProdutoStocavel($valor)
    {

        if ($valor == 'Não') {
            $this->produto['quantidade'] = 0;
            $this->desabledStock = true;
        } else {
            $this->desabledStock = false;
        }
    }
    public function updatedProdutoPrecoCompra()
    {
        if ($this->margemLucro > 0) {
            $preco_compra = (int) $this->produto['preco_compra'] ?? 0;
            $margemLucro = (int) $this->margemLucro ?? 0;

            if ($preco_compra > 0 && $margemLucro > 0) {
                $this->produto['preco_venda'] = $preco_compra + (($preco_compra * $margemLucro) / 100);
            }
        }
    }
    public function updatedmargemLucro()
    {
        $preco_compra = (int) $this->produto['preco_compra'] ?? 0;
        $margemLucro = (int) $this->margemLucro ?? 0;

        if ($preco_compra > 0 && $margemLucro > 0) {
            $this->produto['preco_venda'] = $preco_compra + (($preco_compra * $margemLucro) / 100);
        }
    }

    public function store()
    {

        $rules = [
            'produto.designacao' => ['required'],
            'produto.categoria_id' => ['required'],
            'produto.preco_venda' => ['required', function ($atr, $precoVenda, $fail) {
                if ($precoVenda < 0) {
                    $fail('O preço de venda não pode ser negativo');
                }
            }],
            'produto.status_id' => ['required'],
            'produto.codigo_taxa' => ['required'],
            'produto.fabricante_id' => ['required'],
            'produto.imagem_produto' => ['required'],

        ];
        $messages = [
            'produto.designacao.required' => 'É obrigatório o nome',
            'produto.categoria_id.required' => 'É obrigatório a categoria',
            'produto.fabricante_id.required' => 'É obrigatório o fabricante',
            'produto.preco_venda.required' => 'É obrigatório o preço de venda',
            'produto.status_id.required' => 'É obrigatório o status',
            'produto.imagem_produto.required' => 'Informe a imagem principal',
            'produto.unidade_medida_id' => ''
        ];
        $this->validate($rules, $messages);

        try {

            DB::beginTransaction();

            $produtId = DB::table('produtos')->insertGetId([
                'uuid' => Str::uuid(),
                'designacao' => $this->produto['designacao'],
                'preco_venda' => str_replace(",", ".", $this->produto['preco_venda']),
                'preco_compra' => str_replace(",", ".", $this->produto['preco_compra']),
                'categoria_id' => $this->produto['categoria_id'],
                'unidade_medida_id' => $this->produto['unidade_medida_id'],
                'fabricante_id' => $this->produto['fabricante_id'],
                'user_id' => auth()->user()->id,
                'canal_id' => 2,
                'venda_online' => $this->produto['venda_online'] ? 'Y' : 'N',
                'status_id' => $this->produto['status_id'],
                'codigo_taxa' => $this->produto['codigo_taxa'],
                'motivo_isencao_id' => !isset($this->produto['motivo_isencao_id']) && !$this->produto['motivo_isencao_id'] ? $this->produto['motivo_isencao_id'] : 8, //Transmissão de bens e serviço não sujeita
                'quantidade_minima' => $this->produto['quantidade_minima'] ?? 0,
                'quantidade_critica' => $this->produto['quantidade_critica'] ?? 0,
                'imagem_produto' => env('APP_URL') . "upload/" . $this->uploadFile($this->produto['imagem_produto']),
                'referencia' => Keygen::numeric(9)->generate(),
                'stocavel' => $this->produto['stocavel'],
                'empresa_id' => auth()->user()->empresa_id
            ]);

            if (count($this->produto['imagens']) > 0) {
                $this->inserirArquivoAdicionaisDB($produtId);
            }

            DB::table('existencias_stocks')->insertGetId([
                'produto_id' => $produtId,
                'armazem_id' => $this->produto['armazem_id'],
                'quantidade' => $this->produto['quantidade'] ?? 0,
                'user_id' => auth()->user()->id,
                'canal_id' => 2,
                'status_id' => $this->produto['status_id'],
                'empresa_id' => auth()->user()->empresa_id,
                'created_at' => Carbon::now()->format('Y-m-d'),
                'updated_at' => Carbon::now()->format('Y-m-d'),
            ]);

            DB::table('actualizacao_stocks')->insert([
                'produto_id' => $produtId,
                'empresa_id' => auth()->user()->empresa_id,
                'quantidade_antes' => 0,
                'quantidade_nova' => $this->produto['quantidade'] ?? 0,
                'user_id' => auth()->user()->id,
                'tipo_user_id' => 2, //empresa
                'canal_id' => 2,
                'status_id' => $this->produto['status_id'],
                'armazem_id' => $this->produto['armazem_id'],
                'created_at' => Carbon::now()->format('Y-m-d'),
                'updated_at' => Carbon::now()->format('Y-m-d'),
            ]);
            DB::commit();
            $this->confirm('Operação realizada com sucesso', [
                'showConfirmButton' => false,
                'showCancelButton' => false,
                'icon' => 'success'
            ]);
            $this->setarValor2();
        } catch (\Exception $th) {
            DB::rollBack();
            $this->confirm('Erro', [
                'showConfirmButton' => false,
                'showCancelButton' => false,
                'icon' => 'warning'
            ]);
        }
    }

    public function inserirArquivoAdicionaisDB($produtoId): void
    {
        foreach ($this->produto['imagens'] as $imagem) {
            $path = $this->uploadFile($imagem);
            DB::table('produto_imagens')->insertGetId([
                'url' => env('APP_URL') . "upload/" . $path,
                'produto_id' => $produtoId,
            ]);
        }
    }
    public function uploadFile($imagem)
    {
        return Storage::disk('public')->putFile('produtos', $imagem);
    }
    public function setarValor2()
    {

        $this->produto['designacao'] = NULL;
        $this->produto['preco_venda'] = NULL;
        $this->produto['preco_compra'] = NULL;
        $this->produto['venda_online'] = false;
        $this->produto['imagens'] = [];
        $this->produto['marca_id'] = NULL;
        $this->produto['classe_id'] = NULL;
        $this->produto['canal_id'] = 2;
        $this->produto['quantidade_minima'] = 0;
        $this->produto['quantidade_critica'] = 0;
        $this->produto['categoria_id'] = 1;
        $this->produto['status_id'] = 1;
        $this->produto['stocavel'] = "Sim";
        $this->produto['quantidade'] = 0;
        $this->produto['armazem_id'] = DB::table('armazens')->where('empresa_id', auth()->user()->empresa_id)->orderBy('id', 'asc')->first()->id;
        $this->produto['unidade_medida_id'] = DB::table('unidade_medidas')->where('empresa_id', auth()->user()->empresa_id)->orderBy('id', 'asc')->first()->id;
        $this->produto['fabricante_id'] = DB::table('fabricantes')->where('empresa_id', auth()->user()->empresa_id)->orderBy('id', 'asc')->first()->id;
        $this->produto['codigo_taxa'] = 1;
        $this->produto['motivo_isencao_id'] = 8;
        $this->produto['imagem_produto'] = null;
        $this->produto['margemLucro'] = 0;
    }
}
