<?php

namespace App\Services;

use App\Models\AcaoEnfermagem;
use App\Models\AcaoMedicina;
use App\Models\AcaoNutricao;
use App\Models\AlteracaoLaboratorial;
use App\Models\ClassificacaoMedicamento;
use App\Models\Interacao;
use App\Models\Medicamento;
use App\Models\PrincipioAtivo;
use App\Models\Sintomatologia;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class MedicamentoService
{
    /**
     * Pesquisa medicamentos com base em filtros.
     * 
     * @param array<string, mixed> $filters
     * @return LengthAwarePaginator
     */
    public function search(array $filters): LengthAwarePaginator
    {
        $query = Medicamento::query()
            ->with(['principioAtivo', 'classificacao']);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nome_comercial', 'ilike', "%{$search}%")
                    ->orWhereHas('principioAtivo', function ($q) use ($search) {
                        $q->where('nome_principio_ativo', 'ilike', "%{$search}%");
                    })
                    ->orWhereHas('sintomatologia', function ($q) use ($search) {
                        $q->where('descricao', 'ilike', "%{$search}%");
                    })
                    ->orWhereHas('alteracaoLaboratorial', function ($q) use ($search) {
                        $q->where('descricao', 'ilike', "%{$search}%");
                    });
            });
        }

        if (!empty($filters['classificacao'])) {
            $query->where('id_classificacao', $filters['classificacao']);
        }

        return $query->paginate(10)->withQueryString();
    }

    /**
     * Busca um medicamento com todas as suas relações carregadas.
     */
    public function getDetailed(Medicamento $medicamento): Medicamento
    {
        return $medicamento->load([
            'principioAtivo',
            'classificacao',
            'sintomatologia',
            'alteracaoLaboratorial',
            'interacao',
            'acaoMedicina',
            'acaoNutricao',
            'acaoEnfermagem',
            'interacoesComoOrigem.alvo',
            'interacoesComoOrigem.interacao',
        ]);
    }

    /**
     * Retorna os dados para as tabelas de referência (lookups).
     * 
     * @return array<string, Collection>
     */
    public function getLookups(): array
    {
        return [
            'principios_ativos' => PrincipioAtivo::orderBy('nome_principio_ativo')->get(),
            'classificacoes' => ClassificacaoMedicamento::orderBy('classificacao')->get(),
            'sintomatologias' => Sintomatologia::orderBy('descricao')->get(),
            'alteracoes_laboratoriais' => AlteracaoLaboratorial::orderBy('descricao')->get(),
            'interacoes' => Interacao::orderBy('descricao')->get(),
            'acoes_medicina' => AcaoMedicina::orderBy('descricao')->get(),
            'acoes_nutricao' => AcaoNutricao::orderBy('descricao')->get(),
            'acoes_enfermagem' => AcaoEnfermagem::orderBy('descricao')->get(),
        ];
    }

    /**
     * Cria um novo medicamento.
     */
    public function create(array $data): Medicamento
    {
        return Medicamento::create($data);
    }

    /**
     * Atualiza um medicamento existente.
     */
    public function update(Medicamento $medicamento, array $data): bool
    {
        return $medicamento->update($data);
    }

    /**
     * Remove um medicamento.
     */
    public function delete(Medicamento $medicamento): ?bool
    {
        return $medicamento->delete();
    }
}
