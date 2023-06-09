<?php

namespace App\Repositories\Admin;

use App\Models\admin\Bancos;
use App\Models\admin\CoordenadaBancaria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class BancoRepository
{

    protected $banco;
    protected $coordenadaBancaria;

    public function __construct(Bancos $banco, CoordenadaBancaria $coordenadaBancaria)
    {
        $this->banco = $banco;
        $this->coordenadaBancaria = $coordenadaBancaria;
    }

    public function createBanco(array $data)
    {

        try {
            DB::beginTransaction();
            $banco  = $this->banco::create([
                'designacao' => $data['designacao'],
                'sigla' => $data['sigla'],
                'uuid' => (string) Str::uuid(),
                'status_id' => $data['status_id'],
                'canal_id' => 3,
                'user_id' => auth()->user()->id
            ]);
            $this->coordenadaBancaria::create([
                'num_conta' => $data['num_conta'],
                'iban' => $data['iban'],
                'banco_id' => $banco->id,
                'status_id' => $data['status_id'],
                'canal_id' => 3,
                'user_id' => auth()->user()->id
            ]);

            DB::commit();
            return $banco;
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
        }
    }
    public function updateBanco($data)
    {

        try {
            DB::beginTransaction();
            $banco = $this->banco::where('uuid', $data['uuid'])->update([
                'designacao' => $data['designacao'],
                'sigla' => $data['sigla'],
                'status_id' => $data['status_id']
            ]);
            $this->coordenadaBancaria::where('banco_id', $data['id'])->update([
                'num_conta' => $data['num_conta'],
                'iban' => $data['iban'],
                'status_id' => $data['status_id']
            ]);

            DB::commit();
            return $banco;
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
        }
    }


    public function getBancos($byStatus = 1, $search = null, $perpage = 10)
    {
        $bancos = Bancos::with(['statuGeral', 'coordernadaBancaria'])->when($byStatus, function ($query) use ($byStatus) {
            $query->where('status_id', $byStatus);
        })->search(trim($search))->paginate($perpage);

        return $bancos;
    }
    public function getBancoUuid(string $uuid)
    {
        $banco = $this->banco::with(['statuGeral', 'coordernadaBancaria'])->where('uuid', $uuid)->first();
        return $banco;
    }
    public function getBanco(int $id)
    {
        $user = $this->banco::find($id);
        return $user;
    }
}
