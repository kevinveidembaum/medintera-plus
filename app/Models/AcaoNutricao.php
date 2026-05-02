<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcaoNutricao extends Model
{
    use HasFactory;

    protected $table = 'acao_nutricao';
    protected $primaryKey = 'id_acao_nut';

    protected $fillable = [
        'descricao',
    ];

    /**
     * @return HasMany<Medicamento, $this>
     */
    public function medicamentos(): HasMany
    {
        return $this->hasMany(Medicamento::class, 'id_acao_nut', 'id_acao_nut');
    }
}
