<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sintomatologia extends Model
{
    use HasFactory;

    protected $table = 'sintomatologia';
    protected $primaryKey = 'id_sintomatologia';

    protected $fillable = [
        'descricao',
    ];

    /**
     * @return HasMany<Medicamento, $this>
     */
    public function medicamentos(): HasMany
    {
        return $this->hasMany(Medicamento::class, 'id_sintomatologia', 'id_sintomatologia');
    }
}
