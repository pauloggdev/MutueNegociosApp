<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('users_admin', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('name');
            $table->string('username')->nullable();
            $table->string('telefone')->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->string('foto')->nullable();
            $table->string('guard')->default('web');
            $table->dateTime('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->integer('canal_id')->default(3);
            $table->integer('tipo_user_id')->default(1);
            $table->integer('status_id')->default(1);
            $table->integer('status_senha_id')->default(1);
            $table->enum('notificarAtivacaoLicenca',['Y','N'])->default('N');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->dropIfExists('users_admin');
    }
}
