<?php

namespace App\Http\Controllers\empresa\Produtos;

use App\Models\empresa\MotivoIsencao;
use App\Models\empresa\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\empresa\TipoMotivoIva;
use App\Models\empresa\TipoTaxa;
use App\Repositories\Empresa\MotivoIsencaoRepository;
use App\Repositories\Empresa\TaxaRepository;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Keygen\Keygen;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Redirect;

class ProdutoUpdateController extends Component
{

    use WithFileUploads;
    use LivewireAlert;

    public $produto;
    public $imagem;
    public $desabledStock = false;
    public $margemLucro;
    public $uuid;
    protected $motivoIsencaoRepository;
    protected $taxaRepository;

    protected $listeners = ['eliminarImage', 'refreshComponent' => '$refresh'];




    public function boot()
    {


        $this->produto['designacao'] = NULL;
        $this->produto['preco_venda'] = NULL;
        $this->produto['preco_compra'] = NULL;
        $this->produto['marca_id'] = NULL;
        $this->produto['classe_id'] = NULL;
        $this->produto['canal_id'] = 2;
        $this->produto['quantidade_minima'] = 0;
        $this->produto['quantidade_critica'] = 0;
        $this->produto['categoria_id'] = 1;
        $this->produto['status_id'] = 1;
        $this->produto['stocavel'] = "Sim";
        $this->produto['quantidade'] = 0;
        $this->produto['armazem_id'] = NULL;
        $this->produto['unidade_medida_id'] = NULL;
        $this->produto['fabricante_id'] = NULL;
        $this->produto['codigo_taxa'] = 1;
        $this->produto['motivo_isencao_id'] = 8;
        $this->produto['imagem_produto'] = null;
        $this->produto['margemLucro'] = 0;
        $this->produto['newImagemProduto'] = NULL;
    }

    public function mount($uuid)
    {
        $this->uuid = $uuid;
        $produto = Produto::with(['produtoImagens'])->where('uuid', $uuid)
            ->where('empresa_id', auth()->user()->empresa_id)->first();

        if (!$produto) {
            return redirect()->back();
        }


        $this->motivoIsencaoRepository = new MotivoIsencaoRepository(new MotivoIsencao());
        $this->taxaRepository = new TaxaRepository(new TipoTaxa());
        $this->motivos =  $this->motivoIsencaoRepository->listarMotivosPelaTaxa($produto['codigo_taxa']);
        $this->taxas = $this->taxaRepository->listarTaxas();

        $this->produto['designacao'] = $produto['designacao'];
        $this->produto['categoria_id'] = $produto['categoria_id'];
        $this->produto['preco_compra'] = $produto['preco_compra'];
        $this->produto['preco_venda'] = $produto['preco_venda'];
        $this->produto['status_id'] = $produto['status_id'];
        $this->produto['quantidade_minima'] = $produto['quantidade_minima'];
        $this->produto['quantidade_critica'] = $produto['quantidade_critica'];
        $this->produto['stocavel'] = $produto['stocavel'];
        $this->produto['quantidade'] = $produto->existenciaEstock[0]['quantidade'] ?? 0;
        $this->produto['armazem_id'] = $produto->existenciaEstock[0]['armazem_id'];
        $this->produto['unidade_medida_id'] = $produto['unidade_medida_id'];
        $this->produto['fabricante_id'] = $produto['fabricante_id'];
        $this->produto['codigo_taxa'] = $produto['codigo_taxa'];
        $this->produto['venda_online'] = $produto['venda_online'] == 'Y' ? true : false;
        $this->produto['motivo_isencao_id'] = $produto['motivo_isencao_id'];
        $this->produto['imagem_produto'] = $produto['imagem_produto'];
        $this->produto['produto_imagens'] = $produto['produtoImagens'];
        $this->produto['newImagens'] = [];
    }

    public function render()
    {
        if ($this->produto['stocavel'] == 'Não') {
            $this->quantidade = 0;
        }
        $data['categorias'] = DB::table('categorias')->where('empresa_id', auth()->user()->empresa_id)
            ->orwhere('empresa_id', NULL)->orderBy('id', 'asc')
            ->get();

        $data['armazens'] = DB::table('armazens')->where('empresa_id', auth()->user()->empresa_id)->orderBy('id', 'asc')
            ->get();
        $data['status'] = DB::table('status_gerais')->orderBy('id', 'asc')
            ->get();
        $data['unidades'] = DB::table('unidade_medidas')->where('empresa_id', auth()->user()->empresa_id)->orderBy('id', 'asc')
            ->get();
        $data['fabricantes'] = DB::table('fabricantes')->where('empresa_id', auth()->user()->empresa_id)->orderBy('id', 'asc')
            ->get();

        return view('empresa.produtos.edit', $data);
    }
    public function modalDelImagem($imagem)
    {
        $this->imagem = $imagem;
        $this->confirm('Deseja apagar a imagem?', [
            'onConfirmed' => 'eliminarImage',
            'cancelButtonText' => 'Não',
            'confirmButtonText' => 'Sim',
        ]);
    }
    public function eliminarImage($data)
    {
        if ($data['value']) {
            DB::connection('mysql2')->table('produto_imagens')
                ->where('id', $this->imagem['id'])->delete();

            if (Storage::exists($this->imagem['url'])) {
                Storage::delete($this->imagem['url']);
            }

            return  redirect()->to(url()->previous())->with('success', 'produto actualizado com sucesso');
        }
    }
    public function updatedProdutoCodigoTaxa($taxaId)
    {
        $motivoIsencaoRepository = new MotivoIsencaoRepository(new MotivoIsencao());
        $this->motivos =  $motivoIsencaoRepository->listarMotivosPelaTaxa($taxaId);
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
    public function updatedprodutoVendaOnline($check)
    {
        $this->produto['venda_online'] = $check ? true : false;
    }

    public function update()
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
            'produto.fabricante_id' => ['required']
        ];
        $messages = [
            'produto.designacao.required' => 'É obrigatório o nome',
            'produto.categoria_id.required' => 'É obrigatório a categoria',
            'produto.fabricante_id.required' => 'É obrigatório o fabricante',
            'produto.preco_venda.required' => 'É obrigatório o preço de venda',
            'produto.status_id.required' => 'É obrigatório o status',
        ];

        $this->validate($rules, $messages);



        $produto = Produto::where('uuid', $this->uuid)
            ->where('empresa_id', auth()->user()->empresa_id)->first();

        if (!$produto) {
            return redirect()->back();
        }

        $imagem = NULL;
        if ($this->produto['newImagemProduto']) {
            if (Storage::exists($produto->imagem_produto)) {
                Storage::delete($produto->imagem_produto);
            }
            $imagem =  env('APP_URL') . "upload/" . $this->produto['newImagemProduto']->store("/produtos");
        }

        if (count($this->produto['newImagens']) > 0) {
            foreach ($this->produto['newImagens'] as $img) {
                $img = env('APP_URL') . "upload/" . $img->store("/produtos");
                DB::connection('mysql2')->table('produto_imagens')
                    ->insert([
                        'url' => $img,
                        'produto_id' => $produto['id']
                    ]);
            }
        }

        try {

            DB::beginTransaction();

            DB::table('produtos')->where('uuid', $this->uuid)->update([
                'designacao' => $this->produto['designacao'],
                'preco_venda' => $this->produto['preco_venda'],
                'preco_compra' => $this->produto['preco_compra'],
                'categoria_id' => $this->produto['categoria_id'],
                'unidade_medida_id' => $this->produto['unidade_medida_id'],
                'fabricante_id' => $this->produto['fabricante_id'],
                'status_id' => $this->produto['status_id'],
                'codigo_taxa' => $this->produto['codigo_taxa'],
                'motivo_isencao_id' => $this->produto['codigo_taxa'] <= 0 ? 8 : $this->produto['motivo_isencao_id'], //Transmissão de bens e serviço não sujeita
                'quantidade_minima' => $this->produto['quantidade_minima'] ?? 0,
                'quantidade_critica' => $this->produto['quantidade_critica'] ?? 0,
                'imagem_produto' => $imagem ? $imagem : $produto->imagem_produto,
                'stocavel' => $this->produto['stocavel']
            ]);

            if ($this->produto['stocavel'] == 'Não') {
                DB::table('existencias_stocks')->where('produto_id', $produto->id)->update([
                    'quantidade' =>  0
                ]);
            }
            DB::commit();
            $this->confirm('Operação realizada com sucesso', [
                'showConfirmButton' => false,
                'showCancelButton' => false,
                'icon' => 'success'
            ]);
            return  redirect()->to(url()->previous())->with('success', 'produto actualizado com sucesso');

        } catch (\Exception $th) {
            DB::rollBack();
            $this->confirm('Erro', [
                'showConfirmButton' => false,
                'showCancelButton' => false,
                'icon' => 'danger'
            ]);
        }
    }
}
