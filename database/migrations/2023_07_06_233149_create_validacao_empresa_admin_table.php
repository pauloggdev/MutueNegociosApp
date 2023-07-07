<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidacaoEmpresaAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('validacao_empresa', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('endereco');
            $table->integer('pais_id');
            $table->dateTime('expirado_em')->nullable();
            $table->string('token')->nullable();
            $table->string('nif');
            $table->integer('tipo_cliente_id');
            $table->integer('tipo_regime_id')->nullable();
            $table->integer('gestor_cliente_id')->nullable();
            $table->integer('canal_comunicacao_id')->nullable();
            $table->string('logotipo')->nullable();
            $table->string('website')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('email')->nullable();
            $table->string('pessoal_Contacto')->nullable();
            $table->string('cidade')->nullable();
            $table->string('file_alvara')->nullable();
            $table->string('file_nif')->nullable();
            $table->integer('used')->default(0)->comment("0 => não usado 1 -usando");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->dropIfExists('validacao_empresa');
    }
}
