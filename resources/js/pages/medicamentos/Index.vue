<script setup lang="ts">
import { Head, router, Link } from '@inertiajs/vue3';
import { index as medicamentosIndex, show as medicamentosShow, create as medicamentosCreate, edit as medicamentosEdit, destroy as medicamentosDestroy } from '@/routes/medicamentos';
import { ref, watch } from 'vue';
import throttle from 'lodash/throttle';

interface Props {
    medicamentos: {
        data: Array<{
            id_medicamento: number;
            nome_comercial: string;
            principio_ativo?: {
                nome_principio_ativo: string;
            };
            classificacao?: {
                classificacao: string;
            };
        }>;
        links: Array<{ url: string | null; label: string; active: boolean }>;
    };
    classificacoes: Array<{ id_classificacao: number; classificacao: string }>;
    filters: {
        search?: string;
        classificacao?: string;
    };
}

const props = defineProps<Props>();

const search = ref(props.filters.search || '');
const classificacao = ref(props.filters.classificacao || '');

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Medicamentos',
                href: medicamentosIndex(),
            },
        ],
    },
});

watch(
    [search, classificacao],
    throttle(() => {
        router.get(
            medicamentosIndex().url,
            { search: search.value, classificacao: classificacao.value },
            { preserveState: true, replace: true }
        );
    }, 500)
);

function clearFilters() {
    search.value = '';
    classificacao.value = '';
}

function deleteMedicamento(id: number) {
    if (confirm('Tem certeza que deseja excluir este medicamento?')) {
        router.delete(medicamentosDestroy(id).url);
    }
}
</script>

<template>
    <Head title="Medicamentos" />

    <div class="flex h-full flex-1 flex-col gap-4 p-4 lg:p-8">
        <div class="rounded-xl border border-sidebar-border/70 bg-white p-6 shadow-sm dark:border-sidebar-border dark:bg-zinc-900">
            <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Busca de Medicamentos</h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Pesquise por nome, princípio ativo ou filtre por classe.</p>
                </div>
                <Link
                    :href="medicamentosCreate().url"
                    class="inline-flex items-center rounded-lg bg-zinc-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-zinc-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-900 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200"
                >
                    Novo Medicamento
                </Link>
            </div>

            <!-- Filtros -->
            <div class="mb-8 flex flex-col gap-4 md:flex-row">
                <div class="relative flex-1">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Pesquisar medicamento ou princípio ativo..."
                        class="w-full rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm focus:border-primary-500 focus:outline-hidden focus:ring-2 focus:ring-primary-500/20 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                    />
                </div>
                <div class="w-full md:w-64">
                    <select
                        v-model="classificacao"
                        class="w-full rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm focus:border-primary-500 focus:outline-hidden focus:ring-2 focus:ring-primary-500/20 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                    >
                        <option value="">Todas as classes</option>
                        <option v-for="cl in classificacoes" :key="cl.id_classificacao" :value="cl.id_classificacao">
                            {{ cl.classificacao }}
                        </option>
                    </select>
                </div>
                <button
                    v-if="search || classificacao"
                    @click="clearFilters"
                    class="text-sm text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200"
                >
                    Limpar filtros
                </button>
            </div>

            <!-- Tabela -->
            <div class="overflow-hidden rounded-lg border border-zinc-200 dark:border-zinc-700">
                <table class="w-full text-left text-sm text-zinc-700 dark:text-zinc-300">
                    <thead class="bg-zinc-50 text-xs font-semibold uppercase text-zinc-500 dark:bg-zinc-800/50 dark:text-zinc-400">
                        <tr>
                            <th class="px-6 py-3">Nome Comercial</th>
                            <th class="px-6 py-3">Princípio Ativo</th>
                            <th class="px-6 py-3">Classificação</th>
                            <th class="px-6 py-3 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        <tr v-for="med in medicamentos.data" :key="med.id_medicamento" class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="px-6 py-4 font-medium text-zinc-900 dark:text-white">
                                {{ med.nome_comercial }}
                            </td>
                            <td class="px-6 py-4">
                                {{ med.principio_ativo?.nome_principio_ativo || '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="rounded-full bg-zinc-100 px-2 py-1 text-xs dark:bg-zinc-800">
                                    {{ med.classificacao?.classificacao || 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-3">
                                    <Link 
                                        :href="medicamentosShow(med.id_medicamento).url"
                                        class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400"
                                    >
                                        Ver
                                    </Link>
                                    <Link 
                                        :href="medicamentosEdit(med.id_medicamento).url"
                                        class="font-medium text-zinc-600 hover:text-zinc-500 dark:text-zinc-400"
                                    >
                                        Editar
                                    </Link>
                                    <button 
                                        @click="deleteMedicamento(med.id_medicamento)"
                                        class="font-medium text-red-600 hover:text-red-500 dark:text-red-400"
                                    >
                                        Excluir
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="medicamentos.data.length === 0">
                            <td colspan="4" class="px-6 py-12 text-center text-zinc-500">
                                Nenhum medicamento encontrado com os filtros selecionados.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Paginação (Simplificada) -->
            <div v-if="medicamentos.links.length > 3" class="mt-6 flex items-center justify-between">
                <div class="text-xs text-zinc-500">
                    Mostrando {{ medicamentos.data.length }} resultados
                </div>
                <div class="flex gap-2">
                    <template v-for="(link, k) in medicamentos.links" :key="k">
                        <component
                            :is="link.url ? 'Link' : 'span'"
                            v-if="link.url"
                            :href="link.url"
                            v-html="link.label"
                            class="rounded-md border border-zinc-200 px-3 py-1 text-xs hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800"
                            :class="{ 'bg-primary-500 text-white border-primary-500 hover:bg-primary-600': link.active }"
                        />
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>
