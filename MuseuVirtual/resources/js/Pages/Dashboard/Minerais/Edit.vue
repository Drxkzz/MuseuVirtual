<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, usePage } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';
import TinyMCEEditor from '@/Components/TinyMCEEditor.vue';

const props = defineProps({
    mineral: Object,
    jazidas : Array
});

const mineral = ref({ ...props.mineral });
const page = usePage();
const successMessage = computed(() => page.props?.flash?.success ?? null);

onMounted(() => {
    console.log('Mineral:', mineral.value);
    console.log('Mineral', mineral.value.jazida_id);
});

function submitForm() {
    router.put(route('minerais.update', mineral.value.id), mineral.value);
}

function submitDeleteFoto(id) {
    if (confirm('Tem certeza que deseja excluir esta foto?')) {
        router.delete(route('fotos-destroy', id), {
            onSuccess: () => {
                mineral.value.fotos = mineral.value.fotos.filter(foto => foto.id !== id);
            }
        });
    }
}
</script>

<template>
    <Head title="Editar Mineral" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div v-if="successMessage" class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                            {{ successMessage }}
                        </div>

                        <form @submit.prevent="submitForm">
                            <div class="mb-4">
                                <label for="nome" class="block mt-1 w-full">Nome</label>
                                <input type="text" v-model="mineral.nome" id="nome" required
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 
                                           rounded-md shadow-sm">
                            </div>

                            <div class="mb-4">
                                <label for="descricao" class="block mt-1 w-full">Descrição</label>
                                <TinyMCEEditor v-model="mineral.descricao" />
                            </div>

                            <div class="mb-4">
                                <label for="propriedades" class="block mt-1 w-full">Propriedades</label>
                                <textarea v-model="mineral.propriedades" id="propriedades" rows="4"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 
                                           rounded-md shadow-sm"></textarea>
                            </div>
                            
                            <div class="mb-4">
                                <label for="jazida" class="block mt-1 w-full">Jazida Associada</label>
                                <select v-model="mineral.jazida_id" id="jazida"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                                            focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600
                                            rounded-md shadow-sm">
                                    <option value="">Nenhuma jazida associada</option>
                                    <option v-for="jazida in props.jazidas" :key="jazida.id" :value="jazida.id">
                                    {{ jazida.localizacao }}
                                    </option>
                                </select>
                            </div>

                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Salvar
                            </button>

                            

                        </form>

                        <div class="mt-8 flex flex-wrap justify-center border-gray-300 dark:border-gray-700 rounded-md shadow-sm">
                            <h2 class="self-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                Fotos do Mineral:
                            </h2>
                            <a :href="route('fotos-create', { idMineral: mineral.id })"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 ml-4">
                                Adicionar Fotos
                            </a>
                        </div>

                        <div class="flex flex-wrap border-gray-300 dark:border-gray-700 rounded-md shadow-sm mt-4">
                            <p v-if="!mineral.fotos || mineral.fotos.length === 0">Não existem imagens cadastradas para este mineral.</p>
                            <div v-else v-for="foto in mineral.fotos" :key="foto.id"
                                class="flex flex-col h-[212px] w-[160px] items-center justify-between p-2 m-2 border rounded-md dark:border-gray-700">
                                <img :src="`/storage/${foto.caminho}`" alt="Foto do Mineral." class="h-[144px] w-[128px] object-cover mb-2">
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