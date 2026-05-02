<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcaoMedicina extends Model
{
    use HasFactory;

    protected $table = 'acao_medicina';
    protected $primaryKey = 'id_acao_med';

    protected $fillable = [
        'descricao',
    ];

    /**
     * @return HasMany<Medicamento, $this>
     */
    public function medicamentos(): HasMany
    {
        return $this->hasMany(Medicamento::class, 'id_acao_med', 'id_acao_med');
    }
}
