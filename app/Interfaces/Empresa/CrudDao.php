<?php

namespace App\Interfaces\Empresa;
use Illuminate\Http\Request;

interface  CrudDao{

    public function all();
    public function store(Request $request);
    public function update(Request $request, $id);
    public function destroy($id);
}