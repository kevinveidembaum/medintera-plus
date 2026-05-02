<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicamento extends Model
{
    use HasFactory;

    protected $table = 'medicamento';
    protected $primaryKey = 'id_medicamento';

    protected $fillable = [
        'nome_comercial',
        'id_principio_ativo',
        'id_classificacao',
        'id_sintomatologia',
        'id_alt_lab',
        'id_interacao',
        'id_acao_med',
        'id_acao_nut',
        'id_acao_enf',
        'observacoes',
    ];

    /**
     * @return BelongsTo<PrincipioAtivo, $this>
     */
    public function principioAtivo(): BelongsTo
    {
        return $this->belongsTo(PrincipioAtivo::class, 'id_principio_ativo', 'id_principio_ativo');
    }

    /**
     * @return BelongsTo<ClassificacaoMedicamento, $this>
     */
    public function classificacao(): BelongsTo
    {
        return $this->belongsTo(ClassificacaoMedicamento::class, 'id_classificacao', 'id_classificacao');
    }

    /**
     * @return BelongsTo<Sintomatologia, $this>
     */
    public function sintomatologia(): BelongsTo
    {
        return $this->belongsTo(Sintomatologia::class, 'id_sintomatologia', 'id_sintomatologia');
    }

    /**
     * @return BelongsTo<AlteracaoLaboratorial, $this>
     */
    public function alteracaoLaboratorial(): BelongsTo
    {
        return $this->belongsTo(AlteracaoLaboratorial::class, 'id_alt_lab', 'id_alt_lab');
    }

    /**
     * @return BelongsTo<Interacao, $this>
     */
    public function interacao(): BelongsTo
    {
        return $this->belongsTo(Interacao::class, 'id_interacao', 'id_interacao');
    }

    /**
     * @return BelongsTo<AcaoMedicina, $this>
     */
    public function acaoMedicina(): BelongsTo
    {
        return $this->belongsTo(AcaoMedicina::class, 'id_acao_med', 'id_acao_med');
    }

    /**
     * @return BelongsTo<AcaoNutricao, $this>
     */
    public function acaoNutricao(): BelongsTo
    {
        return $this->belongsTo(AcaoNutricao::class, 'id_acao_nut', 'id_acao_nut');
    }

    /**
     * @return BelongsTo<AcaoEnfermagem, $this>
     */
    public function acaoEnfermagem(): BelongsTo
    {
        return $this->belongsTo(AcaoEnfermagem::class, 'id_acao_enf', 'id_acao_enf');
    }

    /**
     * @return HasMany<MedicamentoInteracao, $this>
     */
    public function interacoesComoOrigem(): HasMany
    {
        return $this->hasMany(MedicamentoInteracao::class, 'medicamento_origem', 'id_medicamento');
    }

    /**
     * @return HasMany<MedicamentoInteracao, $this>
     */
    public function interacoesComoAlvo(): HasMany
    {
        return $this->hasMany(MedicamentoInteracao::class, 'medicamento_alvo', 'id_medicamento');
    }
}
