<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrincipioAtivo extends Model
{
    use HasFactory;

    protected $table = 'principio_ativo';
    protected $primaryKey = 'id_principio_ativo';

    protected $fillable = [
        'nome_principio_ativo',
    ];

    /**
     * @return HasMany<Medicamento, $this>
     */
    public function medicamentos(): HasMany
    {
        return $this->hasMany(Medicamento::class, 'id_principio_ativo', 'id_principio_ativo');
    }
}
