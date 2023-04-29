<?php

namespace App\Repositories\Empresa;

use App\Repositories\contracts\IreportRepositoryInterface;
use App\Repositories\Empresa\contracts\RelatorioRepositoryInterface;
use Illuminate\Support\Facades\App;

class RelatorioRepository implements RelatorioRepositoryInterface
{

    private $ireportRepository;

    public function __construct()
    {
        $this->ireportRepository = App::make(IreportRepositoryInterface::class);
    }

    public function print(string $filename, array $parameters = [])
    {
        $params = [
            'report_file' => $filename,
            'report_jrxml' => $filename . '.jrxml',
            'report_parameters' => $parameters
        ];
        return $this->ireportRepository->show($params);
    }
}
