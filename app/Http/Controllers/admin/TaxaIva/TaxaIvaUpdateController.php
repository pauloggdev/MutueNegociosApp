<?php

namespace App\Http\Controllers\admin\TaxaIva;

use App\Http\Requests\Admin\UpdateTaxaRequest;
use App\Repositories\Admin\TaxaIvaRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class TaxaIvaUpdateController extends Component
{

    use LivewireAlert;
    use UpdateTaxaRequest;


    private $taxaIvaRepository;
    public $taxaIva;

    public $taxaId;


    public function mount($id)
    {
        $this->taxaId = $id;
        $this->taxaIva = $this->taxaIvaRepository->getTaxaIva($id);
    }
    public function boot(TaxaIvaRepository $taxaIvaRepository)
    {
        $this->taxaIvaRepository = $taxaIvaRepository;
    }

    public function render()
    {

        return view('admin.taxasIva.edit')->layout('layouts.appAdmin');
    }
    public function updateTaxa()
    {
        $this->validate($this->rules(), $this->messages());
        $this->taxaIvaRepository->updateTaxa($this->taxaIva);
        $this->alert('success', 'Operação realizada com sucesso');
    }
}
