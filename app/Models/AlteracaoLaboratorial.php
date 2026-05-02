<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AlteracaoLaboratorial extends Model
{
    use HasFactory;

    protected $table = 'alteracao_laboratorial';
    protected $primaryKey = 'id_alt_lab';

    protected $fillable = [
        'descricao',
    ];

    /**
     * @return HasMany<Medicamento, $this>
     */
    public function medicamentos(): HasMany
    {
        return $this->hasMany(Medicamento::class, 'id_alt_lab', 'id_alt_lab');
    }
}
