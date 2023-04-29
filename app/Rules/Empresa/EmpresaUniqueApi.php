<?php

namespace App\Rules\Empresa;

use App\Empresa\GerenciaEmpresaApi;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Array_;

class EmpresaUniqueApi implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $table;
    private $column;
    private $columnValue;
    private $connection;
    private $statusColumn;
    private $valueColumnStatus;

    public function __construct($table, $connection = "mysql2",$column = 'id', $columnValue = null,$statusColumn = "status_id",$valueColumnStatus = 1)
    {

        $this->table = $table;
        $this->column = $column;
        $this->columnValue = $columnValue;
        $this->connection = $connection;
        $this->statusColumn = $statusColumn;
        $this->valueColumnStatus = $valueColumnStatus;
        
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
        $empresa_id = app(GerenciaEmpresaApi::class)->getEmpresaIdentificacao();

        

        $result = DB::connection($this->connection)->table($this->table)
            ->where($attribute, $value)
            ->where('empresa_id', $empresa_id)
            ->where($this->statusColumn, $this->valueColumnStatus)
            ->first();


            //dd($result && $result->{$this->column} == $this->columnValue);

           // dd($result);
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
