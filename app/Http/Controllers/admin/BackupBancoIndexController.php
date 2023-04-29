<?php

namespace App\Http\Controllers\admin;

use Spatie\DbDumper\Databases\MySql;

use Livewire\Component;

class BackupBancoIndexController extends Component
{

    public function render()
    {
        return view('admin.backup.index')->layout('layouts.appAdmin');
    }
    public function exportarBancoCliente()
    {
        $filename = 'mutuenegociosClienteDB.sql';
        if (file_exists($filename)) {
            unlink($filename);
        }

        MySql::create()
            ->setDbName(env('DB_DATABASE2'))
            ->setUserName(env('DB_USERNAME2'))
            ->setPassword(env('DB_PASSWORD2'))
            ->dumpToFile('mutuenegociosClienteDB.sql');

        header('Content-Description: application/sql');
        header('Content-Type: application/sql');
        header('Content-Disposition:; filename=' . $filename);
        readfile($filename);
        unlink($filename);
        flush();
    }
    public function exportarBancoAdmin()
    {
        $filename = 'mutuenegociosAdminDB.sql';
        if (file_exists($filename)) {
            unlink($filename);
        }

        MySql::create()
            ->setDbName(env('DB_DATABASE'))
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'))
            ->dumpToFile('mutuenegociosAdminDB.sql');

        header('Content-Description: application/sql');
        header('Content-Type: application/sql');
        header('Content-Disposition:; filename=' . $filename);
        readfile($filename);
        unlink($filename);
        flush();
    }
}
