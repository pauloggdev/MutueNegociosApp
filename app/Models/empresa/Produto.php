<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;
use Keygen\Keygen;

class Produto extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'produtos';
    protected $primaryKey = "id";
    protected $guarded = ['id'];

    public static function boot()
    {

        parent::boot();

        self::creating(function ($model) {
            $model->referencia = mb_strtoupper(Keygen::alphanum(9)->generate());
        });
    }

    public function statuGeral()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }
    public function tipoTaxa()
    {
        return $this->belongsTo(TipoTaxa::class, 'codigo_taxa', 'codigo');
    }
    public function unidade()
    {
        return $this->belongsTo(UnidadeMedida::class, 'unidade_medida_id');
    }
    public function unidadeMedida()
    {
        return $this->belongsTo(UnidadeMedida::class, 'unidade_medida_id');
    }
    public function existenciaEstock()
    {
        return $this->hasMany(ExistenciaStock::class, 'produto_id');
    }
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classe_id');
    }
    public function fabricante()
    {
        return $this->belongsTo(Fabricante::class, 'fabricante_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function canal()
    {
        return $this->belongsTo(CanalComunicacao::class, 'canal_id');
    }
    public function status()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }
    public function motivoIsencao()
    {
        return $this->belongsTo(TipoMotivoIva::class, 'motivo_isencao_id');
    }
    public function empresa()
    {
        return $this->belongsTo(Empresa_Cliente::class, 'empresa_id');
    }
    public function classificacao(){
        return $this->hasMany(Classificacao::class);
    }
    public function produtoImagens()
    {
        return $this->hasMany(ProdutoImagem::class, 'produto_id', 'id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";

        $query->where(function ($query) use ($term) {
            $query->where("designacao", "like", $term);
        });
    }
    public function scopeVendaOnline($query, $term)
    {

        $query->where(function ($query) use ($term) {
            if ($term == 'N') {
                $query->where("id", '>', 0);
            }
            $query->where("venda_online", $term);
        });
    }
}
