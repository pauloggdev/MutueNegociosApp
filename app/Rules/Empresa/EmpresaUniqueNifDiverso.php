<?php

namespace App\Rules\Empresa;

use App\Empresa\GerenciaEmpresa;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Array_;

class EmpresaUniqueNifDiverso implements Rule
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
    private $columnNif;
    private $columnNifValue;

    public function __construct($table, $connection = "mysql2", $column = 'id', $columnValue = null, $columnNif = 'nif', $columnNifValue = null)
    {
        $this->table = $table;
        $this->column = $column;
        $this->columnValue = $columnValue;
        $this->connection = $connection;
        $this->columnNif = $columnNif;
        $this->columnNifValue = $columnNifValue;
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
        $empresa_id = app(GerenciaEmpresa::class)->getEmpresaIdentificacao();

        $result = DB::connection($this->connection)->table($this->table)
            ->where($attribute, $value)
            ->where('empresa_id', $empresa_id)
            ->first();


        

        if($this->columnNifValue == '999999999'){

            //dd('aqui');
            return is_null(false);
        }


       // dd($this->columnNifValue);
     

        // if ($result && $result->{$this->column} == $this->columnValue && $result->{$this->columnNif} == '999999999')
        //     return true;

        // return is_null($result);
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
