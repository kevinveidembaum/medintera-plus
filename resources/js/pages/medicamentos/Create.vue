<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { index as medicamentosIndex, store as medicamentosStore } from '@/routes/medicamentos';
import InputError from '@/components/InputError.vue';

interface LookupItem {
    id_principio_ativo?: number;
    id_classificacao?: number;
    id_sintomatologia?: number;
    id_alt_lab?: number;
    id_interacao?: number;
    id_acao_med?: number;
    id_acao_nut?: number;
    id_acao_enf?: number;
    nome_principio_ativo?: string;
    classificacao?: string;
    descricao?: string;
}

interface Props {
    lookups: {
        principios_ativos: Array<LookupItem>;
        classificacoes: Array<LookupItem>;
        sintomatologias: Array<LookupItem>;
        alteracoes_laboratoriais: Array<LookupItem>;
        interacoes: Array<LookupItem>;
        acoes_medicina: Array<LookupItem>;
        acoes_nutricao: Array<LookupItem>;
        acoes_enfermagem: Array<LookupItem>;
    };
}

defineProps<Props>();

const form = useForm({
    nome_comercial: '',
    id_principio_ativo: '',
    id_classificacao: '',
    id_sintomatologia: '',
    id_alt_lab: '',
    id_interacao: '',
    id_acao_med: '',
    id_acao_nut: '',
    id_acao_enf: '',
    observacoes: '',
});

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Medicamentos',
                href: medicamentosIndex(),
            },
            {
                title: 'Novo Medicamento',
                href: '#',
            },
        ],
    },
});

function submit() {
    form.post(medicamentosStore().url);
}
</script>

<template>
    <Head title="Novo Medicamento" />

    <div class="flex h-full flex-1 flex-col gap-6 p-4 lg:p-8">
        <div class="rounded-xl border border-sidebar-border/70 bg-white p-6 shadow-sm dark:border-sidebar-border dark:bg-zinc-900">
            <h1 class="mb-6 text-2xl font-bold text-zinc-900 dark:text-white">Cadastrar Novo Medicamento</h1>

            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Nome Comercial -->
                    <div class="col-span-2">
                        <label for="nome_comercial" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Nome Comercial</label>
                        <input
                            id="nome_comercial"
                            v-model="form.nome_comercial"
                            type="text"
                            class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                        />
                        <InputError :message="form.errors.nome_comercial" class="mt-2" />
                    </div>

                    <!-- Princípio Ativo -->
                    <div>
                        <label for="id_principio_ativo" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Princípio Ativo</label>
                        <select
                            id="id_principio_ativo"
                            v-model="form.id_principio_ativo"
                            class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                        >
                            <option value="">Selecione...</option>
                            <option v-for="item in lookups.principios_ativos" :key="item.id_principio_ativo" :value="item.id_principio_ativo">
                                {{ item.nome_principio_ativo }}
                            </option>
                        </select>
                    </div>

                    <!-- Classificação -->
                    <div>
                        <label for="id_classificacao" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Classificação</label>
                        <select
                            id="id_classificacao"
                            v-model="form.id_classificacao"
                            class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                        >
                            <option value="">Selecione...</option>
                            <option v-for="item in lookups.classificacoes" :key="item.id_classificacao" :value="item.id_classificacao">
                                {{ item.classificacao }}
                            </option>
                        </select>
                    </div>

                    <!-- Sintomatologia -->
                    <div>
                        <label for="id_sintomatologia" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Sintomatologia</label>
                        <select
                            id="id_sintomatologia"
                            v-model="form.id_sintomatologia"
                            class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                        >
                            <option value="">Selecione...</option>
                            <option v-for="item in lookups.sintomatologias" :key="item.id_sintomatologia" :value="item.id_sintomatologia">
                                {{ item.descricao }}
                            </option>
                        </select>
                    </div>

                    <!-- Alteração Laboratorial -->
                    <div>
                        <label for="id_alt_lab" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Alteração Laboratorial</label>
                        <select
                            id="id_alt_lab"
                            v-model="form.id_alt_lab"
                            class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                        >
                            <option value="">Selecione...</option>
                            <option v-for="item in lookups.alteracoes_laboratoriais" :key="item.id_alt_lab" :value="item.id_alt_lab">
                                {{ item.descricao }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="space-y-4 rounded-lg bg-zinc-50 p-4 dark:bg-zinc-800/50">
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Ações Multiprofissionais</h3>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium text-primary-700 dark:text-primary-300">Medicina</label>
                            <select v-model="form.id_acao_med" class="mt-1 block w-full rounded-md border-zinc-300 text-sm dark:border-zinc-700 dark:bg-zinc-800">
                                <option value="">Nenhuma</option>
                                <option v-for="item in lookups.acoes_medicina" :key="item.id_acao_med" :value="item.id_acao_med">{{ item.descricao }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-green-700 dark:text-green-300">Nutrição</label>
                            <select v-model="form.id_acao_nut" class="mt-1 block w-full rounded-md border-zinc-300 text-sm dark:border-zinc-700 dark:bg-zinc-800">
                                <option value="">Nenhuma</option>
                                <option v-for="item in lookups.acoes_nutricao" :key="item.id_acao_nut" :value="item.id_acao_nut">{{ item.descricao }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-amber-700 dark:text-amber-300">Enfermagem</label>
                            <select v-model="form.id_acao_enf" class="mt-1 block w-full rounded-md border-zinc-300 text-sm dark:border-zinc-700 dark:bg-zinc-800">
                                <option value="">Nenhuma</option>
                                <option v-for="item in lookups.acoes_enfermagem" :key="item.id_acao_enf" :value="item.id_acao_enf">{{ item.descricao }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="observacoes" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Observações</label>
                    <textarea
                        id="observacoes"
                        v-model="form.observacoes"
                        rows="3"
                        class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                    ></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <Link
                        :href="medicamentosIndex().url"
                        class="rounded-lg border border-zinc-200 px-4 py-2 text-sm font-medium hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800"
                    >
                        Cancelar
                    </Link>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 disabled:opacity-50"
                    >
                        Salvar Medicamento
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
