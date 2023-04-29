<?php

namespace App\Http\Controllers\admin\TaxaIva;

use App\Http\Requests\Admin\StoreTaxaRequest;
use App\Repositories\Admin\TaxaIvaRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class TaxaIvaCreateController extends Component
{

    use LivewireAlert;
    use StoreTaxaRequest;

    private $taxaIvaRepository;
    public $taxaIva;

    public function __construct()
    {
        $this->taxaIva['codigostatus'] = 1;
    }


    public function boot(TaxaIvaRepository $taxaIvaRepository)
    {
        $this->taxaIvaRepository = $taxaIvaRepository;
    }

    public function render()
    {
        return view('admin.taxasIva.create')->layout('layouts.appAdmin');
    }
    public function salvarTaxa()
    {
        $this->validate($this->rules(), $this->messages());
        $this->taxaIvaRepository->createTaxaIva($this->taxaIva);
        $this->alert('success', 'Operação realizada com sucesso');
        $this->setarValorInicial();
    }
    public function setarValorInicial()
    {
        $this->taxaIva['codigostatus'] = 1;
        $this->taxaIva['taxa'] = NULL;
    }
}
