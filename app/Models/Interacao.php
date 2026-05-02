<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Interacao extends Model
{
    use HasFactory;

    protected $table = 'interacao';
    protected $primaryKey = 'id_interacao';

    protected $fillable = [
        'descricao',
    ];

    /**
     * @return HasMany<Medicamento, $this>
     */
    public function medicamentos(): HasMany
    {
        return $this->hasMany(Medicamento::class, 'id_interacao', 'id_interacao');
    }

    /**
     * @return HasMany<MedicamentoInteracao, $this>
     */
    public function medicamentoInteracoes(): HasMany
    {
        return $this->hasMany(MedicamentoInteracao::class, 'id_interacao', 'id_interacao');
    }
}
