<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, usePage } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';

const props = defineProps({
    rocha: {
        type: Object,
        required: true,
    },
});

const rocha = ref({ ...props.rocha });
const page = usePage();
const successMessage = computed(() => page.props?.flash?.success ?? null);

function submitForm() {
    router.put(route('Rocha.update', rocha.value.id), rocha.value);
}

function submitDeleteFoto(id) {
    if (confirm('Tem certeza que deseja excluir esta rocha?')) {
        router.delete(route('fotos-destroy', id), {
            onSuccess: () => {
                rocha.value.fotos = rocha.value.fotos.filter(f => f.id !== id);
            },
        });
    }
}
</script>

<template>
    <Head title="Editar Rocha" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Editar Rocha
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="submitForm">
                            <!-- Nome -->
                            <div class="mb-4">
                                <label for="nome" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nome</label>
                                <input v-model="rocha.nome" id="nome" type="text" required
                                       class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                                              focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring focus:ring-indigo-200 rounded-md shadow-sm">
                            </div>

                            <!-- Descrição -->
                            <div class="mb-4">
                                <label for="descricao" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Descrição</label>
                                <textarea v-model="rocha.descricao" id="descricao" rows="4"
                                          class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                                                 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring focus:ring-indigo-200 rounded-md shadow-sm"></textarea>
                            </div>

                            <!-- Composição -->
                            <div class="mb-4">
                                <label for="composicao" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Composição</label>
                                <input v-model="rocha.composicao" id="composicao" type="text"
                                       class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                                              focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring focus:ring-indigo-200 rounded-md shadow-sm">
                            </div>

                            <!-- Tipo -->
                            <div class="mb-4">
                                <label for="tipo" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tipo de Rocha</label>
                                <select v-model="rocha.tipo" id="tipo" required
                                        class="block mt-1 w-full border-gray-300 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                                    <option value="" disabled>Escolha uma rocha...</option>
                                    <option value="1">Ígneas</option>
                                    <option value="2">Metamórficas</option>
                                    <option value="3">Sedimentares</option>
                                </select>
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <button type="submit"
                                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                                    Salvar Alterações
                                </button>
                            </div>
                        </form>

                        <!-- Galeria de Fotos -->
                        <div class="mt-8 flex flex-wrap justify-center border-gray-300 dark:border-gray-700 rounded-md shadow-sm">
                            <h2 class="self-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                Fotos da rocha
                            </h2>
                            <a :href="route('fotos-create', { idRocha: rocha.id })" class="bg-[#9B9FB5] text-black px-4 py-2 rounded hover:bg-blue-700 ml-4">
                                Adicionar fotos
                            </a>
                        </div>

                        <div class="flex flex-wrap border-gray-300 dark:border-gray-700 rounded-md shadow-sm mt-4">
                            <p v-if="!rocha.fotos || rocha.fotos.length === 0">Não existem imagens cadastradas para esta rocha.</p>
                            <div v-else v-for="foto in rocha.fotos" :key="foto.id"
                                 class="flex flex-col h-[212px] w-[160px] items-center justify-between p-2 m-2 border rounded-md dark:border-gray-700 dark:bg-gray-900">
                                <img :src="`/storage/${foto.caminho}`" alt="Foto da Rocha" class="h-[144px] w-[128px] object-cover mb-2">

                                <div class="flex items-center gap-2">
                                    <a :href="route('fotos-edit', foto.id)" class="bg-gray-600 text-white px-2 py-1 rounded hover:bg-gray-700 text-sm">
                                        Editar
                                    </a>
                                    <button @click="submitDeleteFoto(foto.id)"
                                            class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700 text-sm">
                                        Excluir
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
