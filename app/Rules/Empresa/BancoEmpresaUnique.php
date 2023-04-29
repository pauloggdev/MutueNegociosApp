<?php

namespace App\Rules\Empresa;

use App\Empresa\GerenciaBancoEmpresa;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class BancoEmpresaUnique implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $table;
    private $column;
    private $columnValue;

    public function __construct($table, $columnValue = null, $column = 'id')
    {
        $this->table = $table;
        $this->column = $column;
        $this->columnValue = $columnValue;
        
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $coordenada_id = app(GerenciaBancoEmpresa::class)->getEmpresaIdentificacao();

        $result = DB::table($this->table)
            ->where($attribute, $value)
            ->where('banco_id','=', $coordenada_id)
            ->first();

            //dd($result && $result->{$this->column} == $this->columnValue);

            if($result && $result->{$this->column} == $this->columnValue)
                return true;
            
        return is_null($result);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O valor indicado para o campo :attribute já se encontra registado';
    }
}
