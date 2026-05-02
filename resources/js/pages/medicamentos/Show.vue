<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { index as medicamentosIndex } from '@/routes/medicamentos';
import { show as medicamentosShow } from '@/routes/medicamentos';

interface Props {
    medicamento: {
        id_medicamento: number;
        nome_comercial: string;
        observacoes: string | null;
        principio_ativo?: { nome_principio_ativo: string };
        classificacao?: { classificacao: string };
        sintomatologia?: { descricao: string };
        alteracao_laboratorial?: { descricao: string };
        interacao?: { descricao: string };
        acao_medicina?: { descricao: string };
        acao_nutricao?: { descricao: string };
        acao_enfermagem?: { descricao: string };
        interacoes_como_origem: Array<{
            id_med_interacao: number;
            severidade: string;
            descricao: string;
            alvo: { nome_comercial: string };
            interacao?: { descricao: string };
        }>;
    };
}

const props = defineProps<Props>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Medicamentos',
                href: medicamentosIndex(),
            },
            {
                title: props.medicamento.nome_comercial,
                href: medicamentosShow(props.medicamento.id_medicamento),
            },
        ],
    },
});
</script>

<template>
    <Head :title="medicamento.nome_comercial" />

    <div class="flex h-full flex-1 flex-col gap-6 p-4 lg:p-8">
        <!-- Header -->
        <div class="rounded-xl border border-sidebar-border/70 bg-white p-6 shadow-sm dark:border-sidebar-border dark:bg-zinc-900">
            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-primary-600 dark:text-primary-400">
                        {{ medicamento.classificacao?.classificacao || 'Sem classificação' }}
                    </span>
                    <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ medicamento.nome_comercial }}</h1>
                    <p class="text-lg text-zinc-500 dark:text-zinc-400">
                        Princípio Ativo: <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ medicamento.principio_ativo?.nome_principio_ativo || 'N/A' }}</span>
                    </p>
                </div>
                <Link
                    :href="medicamentosIndex().url"
                    class="rounded-lg border border-zinc-200 px-4 py-2 text-sm font-medium hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800"
                >
                    Voltar para Busca
                </Link>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Informações Gerais -->
            <div class="space-y-6 lg:col-span-2">
                <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                    <h2 class="mb-4 text-xl font-bold text-zinc-900 dark:text-white">Informações Clínicas</h2>
                    
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <h3 class="text-sm font-semibold text-zinc-500 uppercase dark:text-zinc-400">Sintomatologia</h3>
                            <p class="mt-1 text-zinc-700 dark:text-zinc-300">{{ medicamento.sintomatologia?.descricao || 'Nenhuma descrição disponível.' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-zinc-500 uppercase dark:text-zinc-400">Alterações Laboratoriais</h3>
                            <p class="mt-1 text-zinc-700 dark:text-zinc-300">{{ medicamento.alteracao_laboratorial?.descricao || 'Nenhuma alteração documentada.' }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-sm font-semibold text-zinc-500 uppercase dark:text-zinc-400">Observações Gerais</h3>
                        <p class="mt-1 text-zinc-700 dark:text-zinc-300 whitespace-pre-wrap">{{ medicamento.observacoes || 'Sem observações adicionais.' }}</p>
                    </div>
                </div>

                <!-- Interações -->
                <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                    <h2 class="mb-4 text-xl font-bold text-zinc-900 dark:text-white">Interações Medicamentosas</h2>
                    
                    <div v-if="medicamento.interacoes_como_origem.length > 0" class="space-y-4">
                        <div 
                            v-for="int in medicamento.interacoes_como_origem" 
                            :key="int.id_med_interacao"
                            class="rounded-lg border border-zinc-100 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/50"
                        >
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-bold text-zinc-900 dark:text-white">Com: {{ int.alvo.nome_comercial }}</span>
                                <span 
                                    class="rounded px-2 py-0.5 text-xs font-bold uppercase"
                                    :class="{
                                        'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400': int.severidade === 'Grave' || int.severidade === 'Fatal',
                                        'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400': int.severidade === 'Moderada',
                                        'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400': int.severidade === 'Leve',
                                    }"
                                >
                                    {{ int.severidade }}
                                </span>
                            </div>
                            <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ int.descricao }}</p>
                            <p v-if="int.interacao" class="mt-2 text-xs italic text-zinc-500 dark:text-zinc-400">
                                Info adicional: {{ int.interacao.descricao }}
                            </p>
                        </div>
                    </div>
                    <p v-else class="text-zinc-500">Nenhuma interação documentada para este medicamento.</p>
                </div>
            </div>

            <!-- Ações Multiprofissionais -->
            <div class="space-y-6">
                <div class="rounded-xl border border-primary-100 bg-primary-50/30 p-6 shadow-sm dark:border-primary-900/30 dark:bg-primary-900/10">
                    <h2 class="mb-4 text-xl font-bold text-primary-900 dark:text-primary-100">Condutas Médicas</h2>
                    <p class="text-sm text-primary-800 dark:text-primary-200">{{ medicamento.acao_medicina?.descricao || 'Sem orientações específicas.' }}</p>
                </div>

                <div class="rounded-xl border border-green-100 bg-green-50/30 p-6 shadow-sm dark:border-green-900/30 dark:bg-green-900/10">
                    <h2 class="mb-4 text-xl font-bold text-green-900 dark:text-green-100">Condutas Nutrição</h2>
                    <p class="text-sm text-green-800 dark:text-green-200">{{ medicamento.acao_nutricao?.descricao || 'Sem orientações específicas.' }}</p>
                </div>

                <div class="rounded-xl border border-amber-100 bg-amber-50/30 p-6 shadow-sm dark:border-amber-900/30 dark:bg-amber-900/10">
                    <h2 class="mb-4 text-xl font-bold text-amber-900 dark:text-amber-100">Condutas Enfermagem</h2>
                    <p class="text-sm text-amber-800 dark:text-amber-200">{{ medicamento.acao_enfermagem?.descricao || 'Sem orientações específicas.' }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
