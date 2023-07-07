<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CanalComunicacaoSeeder::class,
            UserAdminSeeder::class,
            TipoUserAdminSeeder::class,
            TipoTaxaAdminSeeder::class,
            TipoRegimeAdminSeeder::class,
            TipoLicencaAdminSeeder::class,
            TipoClienteAdminSeeder::class,
            StatusLicencaAdminSeeder::class,
            StatusGeraisAdminSeeder::class
        ]);

    }
}
