<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoTaxaAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('tipotaxa', function (Blueprint $table) {
            $table->id('codigo');
            $table->integer('taxa');
            $table->integer('codigostatus');
            $table->string('descricao')->nullable();
            $table->integer('codigoMotivo');
            $table->integer('empresa_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->dropIfExists('tipotaxa');
    }
}
