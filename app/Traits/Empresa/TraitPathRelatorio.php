<?php
namespace App\Traits\Empresa;


trait TraitPathRelatorio
{
    public function getPathRelatorio()
    {
        return public_path() . '/upload/documentos/empresa/relatorios/';
    }
}
