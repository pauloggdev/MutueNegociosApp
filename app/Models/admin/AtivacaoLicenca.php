<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class AtivacaoLicenca extends Model
{
    protected $table = 'activacao_licencas';
    protected $connection = 'mysql';

    const ATIVO = 1;
    const REJEITADO = 2;
    const PENDENTE = 3;


    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    public function licenca()
    {
        return $this->belongsTo(Licenca::class, 'licenca_id');
    }

    public function statusLicenca()
    {
        return $this->belongsTo(StatuLicencas::class, 'status_licenca_id');
    }
    public function pagamento()
    {
        return $this->belongsTo(Pagamento::class, 'pagamento_id');
    }
    public function scopeAtivo($query)
    {
        $query->where(function ($query) {
            $query->where("status_licenca_id", AtivacaoLicenca::ATIVO);
        });
    }
    public function scopeRejeitado($query)
    {
        $query->where(function ($query) {
            $query->where("status_licenca_id", AtivacaoLicenca::REJEITADO);
        });
    }
    public function scopePendente($query)
    {
        $query->where(function ($query) {
            $query->where("status_licenca_id", AtivacaoLicenca::PENDENTE);
        });
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->whereHas('empresa', function ($query) use ($term) {
            $query->where('nome', 'like', $term)
                ->orwhere('nif', 'like', $term);
        });
    }
   

}
