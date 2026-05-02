<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassificacaoMedicamento extends Model
{
    use HasFactory;

    protected $table = 'classificacao_medicamento';
    protected $primaryKey = 'id_classificacao';

    protected $fillable = [
        'classificacao',
    ];

    /**
     * @return HasMany<Medicamento, $this>
     */
    public function medicamentos(): HasMany
    {
        return $this->hasMany(Medicamento::class, 'id_classificacao', 'id_classificacao');
    }
}
