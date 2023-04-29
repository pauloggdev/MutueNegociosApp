<?php

namespace App\Rules\Empresa;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;


class EmpresaUnicaAdmin implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $table;
    private $connection;
    private $column;
    private $columnValue;


    public function __construct($table, $connection = "mysql", $column = "id", $columnValue = null)
    {
        $this->table = $table;
        $this->connection = $connection;
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
        $result = DB::connection($this->connection)->table($this->table)
            ->where($attribute, $value)->first();

        if ($result && $result->{$this->column} == $this->columnValue) {
            return true;
        }

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
