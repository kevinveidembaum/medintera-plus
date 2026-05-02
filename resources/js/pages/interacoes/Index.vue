<script setup lang="ts">
import { Head, useForm, router, Link } from '@inertiajs/vue3';
import { index as interacoesIndex, store as interacoesStore, update as interacoesUpdate, destroy as interacoesDestroy } from '@/routes/interacoes';
import { ref } from 'vue';
import InputError from '@/components/InputError.vue';

interface Props {
    interacoes: {
        data: Array<{
            id_med_interacao: number;
            medicamento_origem: number;
            medicamento_alvo: number;
            id_interacao: number | null;
            severidade: string;
            descricao: string;
            origem: { nome_comercial: string };
            alvo: { nome_comercial: string };
            interacao?: { descricao: string };
        }>;
        links: Array<any>;
    };
    lookups: {
        medicamentos: Array<{ id_medicamento: number; nome_comercial: string }>;
        interacoes_base: Array<{ id_interacao: number; descricao: string }>;
        severidades: Array<string>;
    };
    filters: {
        search?: string;
        severidade?: string;
    };
}

const props = defineProps<Props>();

const editingId = ref<number | null>(null);

const form = useForm({
    medicamento_origem: '',
    medicamento_alvo: '',
    id_interacao: '',
    severidade: 'Moderada',
    descricao: '',
});

function submit() {
    if (editingId.value) {
        form.put(interacoesUpdate(editingId.value).url, {
            onSuccess: () => resetForm(),
        });
    } else {
        form.post(interacoesStore().url, {
            onSuccess: () => resetForm(),
        });
    }
}

function edit(interacao: any) {
    editingId.value = interacao.id_med_interacao;
    form.medicamento_origem = interacao.medicamento_origem;
    form.medicamento_alvo = interacao.medicamento_alvo;
    form.id_interacao = interacao.id_interacao || '';
    form.severidade = interacao.severidade;
    form.descricao = interacao.descricao;
}

function resetForm() {
    editingId.value = null;
    form.reset();
}

function deleteInteracao(id: number) {
    if (confirm('Deseja excluir esta interação?')) {
        router.delete(interacoesDestroy(id).url);
    }
}

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Interações',
                href: interacoesIndex(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Gestão de Interações" />

    <div class="flex h-full flex-1 flex-col gap-8 p-4 lg:p-8">
        <!-- Formulário de Cadastro/Edição -->
        <div class="rounded-xl border border-sidebar-border/70 bg-white p-6 shadow-sm dark:border-sidebar-border dark:bg-zinc-900">
            <h2 class="mb-6 text-xl font-bold text-zinc-900 dark:text-white">
                {{ editingId ? 'Editar Interação' : 'Nova Interação entre Medicamentos' }}
            </h2>

            <form @submit.prevent="submit" class="space-y-4">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Medicamento Origem</label>
                        <select v-model="form.medicamento_origem" class="mt-1 block w-full rounded-md border-zinc-300 text-sm dark:border-zinc-700 dark:bg-zinc-800">
                            <option value="">Selecione...</option>
                            <option v-for="m in lookups.medicamentos" :key="m.id_medicamento" :value="m.id_medicamento">{{ m.nome_comercial }}</option>
                        </select>
                        <InputError :message="form.errors.medicamento_origem" class="mt-1" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Medicamento Alvo</label>
                        <select v-model="form.medicamento_alvo" class="mt-1 block w-full rounded-md border-zinc-300 text-sm dark:border-zinc-700 dark:bg-zinc-800">
                            <option value="">Selecione...</option>
                            <option v-for="m in lookups.medicamentos" :key="m.id_medicamento" :value="m.id_medicamento">{{ m.nome_comercial }}</option>
                        </select>
                        <InputError :message="form.errors.medicamento_alvo" class="mt-1" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Severidade</label>
                        <select v-model="form.severidade" class="mt-1 block w-full rounded-md border-zinc-300 text-sm dark:border-zinc-700 dark:bg-zinc-800">
                            <option v-for="s in lookups.severidades" :key="s" :value="s">{{ s }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Interação Base (Lookup)</label>
                        <select v-model="form.id_interacao" class="mt-1 block w-full rounded-md border-zinc-300 text-sm dark:border-zinc-700 dark:bg-zinc-800">
                            <option value="">Nenhuma</option>
                            <option v-for="i in lookups.interacoes_base" :key="i.id_interacao" :value="i.id_interacao">{{ i.descricao }}</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Descrição Detalhada do Risco/Conduta</label>
                    <textarea v-model="form.descricao" rows="2" class="mt-1 block w-full rounded-md border-zinc-300 text-sm dark:border-zinc-700 dark:bg-zinc-800"></textarea>
                    <InputError :message="form.errors.descricao" class="mt-1" />
                </div>

                <div class="flex justify-end gap-3">
                    <button v-if="editingId" type="button" @click="resetForm" class="text-sm text-zinc-500 hover:text-zinc-700">Cancelar</button>
                    <button type="submit" :disabled="form.processing" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-500">
                        {{ editingId ? 'Atualizar Interação' : 'Salvar Interação' }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Lista de Interações -->
        <div class="rounded-xl border border-sidebar-border/70 bg-white shadow-sm dark:border-sidebar-border dark:bg-zinc-900 overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-50 text-xs font-semibold uppercase text-zinc-500 dark:bg-zinc-800/50">
                    <tr>
                        <th class="px-6 py-3">Medicamentos Envolvidos</th>
                        <th class="px-6 py-3">Severidade</th>
                        <th class="px-6 py-3">Descrição</th>
                        <th class="px-6 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    <tr v-for="int in interacoes.data" :key="int.id_med_interacao" class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-zinc-900 dark:text-white">{{ int.origem.nome_comercial }}</span>
                                <span class="text-xs text-zinc-400">interage com</span>
                                <span class="font-bold text-zinc-900 dark:text-white">{{ int.alvo.nome_comercial }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
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
                        </td>
                        <td class="px-6 py-4 max-w-md truncate">{{ int.descricao }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-3">
                                <button @click="edit(int)" class="text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white">Editar</button>
                                <button @click="deleteInteracao(int.id_med_interacao)" class="text-red-600 hover:text-red-900 dark:text-red-400">Excluir</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
