<?php

namespace App\Http\Controllers\admin\Traits;

trait TraitPathRelatorio
{
    public function getPathRelatorio()
    {
        return public_path() . '/upload/admin/relatorios/';
    }
}
