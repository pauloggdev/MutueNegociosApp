<?php

namespace App\Http\Controllers\empresa\ManualUtilizador;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class ManualUtilizadorIndexController extends Component
{
    use LivewireAlert;
    

    public function render()
    {
        return view('empresa.manualUtilizador.index');

    }

    public function imprimirManualUtilizador()
    {
        return Storage::download("manualUtilizador.pdf");
    }
}
