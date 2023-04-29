<?php

namespace App\Http\Controllers\admin\Configuracao;

use App\Http\Requests\Admin\UpdateEmpresaRequest;
use App\Repositories\Admin\EmpresaRepository;
use App\Repositories\Admin\RegimeRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class MinhaContaIndexController extends Component
{

    use LivewireAlert;
    use UpdateEmpresaRequest;
    use WithFileUploads;


    private $empresaRepository;
    private $regimeRepository;
    public $empresa;
    public $logotipoAnterior;
    public $logotipoAtual;

    // public $utilizadorId;


    public function mount()
    {
        $this->empresa = $this->empresaRepository->getEmpresaAdmin();
        $this->logotipoAnterior = $this->empresa['logotipo'];
    }
    public function boot(EmpresaRepository $empresaRepository, RegimeRepository $regimeRepository)
    {
        $this->empresaRepository = $empresaRepository;
        $this->regimeRepository = $regimeRepository;
    }

    public function render()
    {

        $data['regimes'] = $this->regimeRepository->getRegimes();

        return view('admin.configuracao.minhaconta', $data)
            ->layout('layouts.appAdmin');
    }
    public function atualizarEmpresa()
    {
        if ($this->logotipoAtual) {
            $this->empresa['logotipoAtual'] = $this->logotipoAtual;
        }
        $this->validate($this->rules(), $this->messages());
        $this->empresaRepository->atualizarEmpresa($this->empresa);
        $this->alert('success', 'Operação realizada com sucesso');
    }
}
