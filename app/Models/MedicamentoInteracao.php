<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicamentoInteracao extends Model
{
    use HasFactory;

    protected $table = 'medicamento_interacao';
    protected $primaryKey = 'id_med_interacao';

    protected $fillable = [
        'medicamento_origem',
        'medicamento_alvo',
        'id_interacao',
        'severidade',
        'descricao',
    ];

    /**
     * @return BelongsTo<Medicamento, $this>
     */
    public function origem(): BelongsTo
    {
        return $this->belongsTo(Medicamento::class, 'medicamento_origem', 'id_medicamento');
    }

    /**
     * @return BelongsTo<Medicamento, $this>
     */
    public function alvo(): BelongsTo
    {
        return $this->belongsTo(Medicamento::class, 'medicamento_alvo', 'id_medicamento');
    }

    /**
     * @return BelongsTo<Interacao, $this>
     */
    public function interacao(): BelongsTo
    {
        return $this->belongsTo(Interacao::class, 'id_interacao', 'id_interacao');
    }
}
