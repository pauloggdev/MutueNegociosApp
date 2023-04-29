<?php

namespace App\Http\Controllers\admin\TaxaIva;

use App\Http\Controllers\admin\Traits\TraitEmpresa;
use App\Http\Controllers\admin\Traits\TraitPathRelatorio;
use App\Repositories\Admin\TaxaIvaRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class TaxaIvaIndexController extends Component
{

    use WithPagination;
    use TraitEmpresa;
    use TraitPathRelatorio;
    use LivewireAlert;



    public $search = null;
    public $byStatus = null;
    public $perpage = 15;
    public $taxaId;

    protected $listeners = ['deletarTaxa'];


    private $taxaIvaRepository;

    public function boot(TaxaIvaRepository $taxaIvaRepository)
    {
        $this->taxaIvaRepository = $taxaIvaRepository;
    }
    public function modalDel($taxaId)
    {
        $this->taxaId = $taxaId;
        $this->confirm('Deseja apagar o item', [
            'onConfirmed' => 'deletarTaxa',
            'cancelButtonText' => 'Não',
            'confirmButtonText' => 'Sim',
        ]);
    }

    public function deletarTaxa($data)
    {
        if ($data['value']) {
            try {
                $this->taxaIvaRepository->deletarTaxa($this->taxaId);
                $this->alert('success', 'Operação realizada com sucesso');
            } catch (\Throwable $th) {
                $this->alert('warning', 'Não permitido eliminar, altera o status como desativo');
            }
        }
    }

    public function render()
    {
        $taxaIvas = $this->taxaIvaRepository->getTaxaIvas($this->search);
        return view('admin.taxasIva.index', [
            'taxaIvas' => $taxaIvas
        ])->layout('layouts.appAdmin');
    }
}
