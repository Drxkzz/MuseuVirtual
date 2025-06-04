<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';

const props = defineProps({
    rochas: Object,
});

const page = usePage();
const successMessage = computed(() => page.props?.flash?.success ?? null);
const popupVisible = ref(false);

onMounted(() => {
    if (successMessage.value) {
        popupVisible.value = true;
        setTimeout(() => {
            popupVisible.value = false;
        }, 3000);
    }
});

function deleteRocha(id) {
    if (confirm('Tem certeza que deseja excluir esta rocha?')) {
        router.delete(route('Rocha.destroy', id));
    }
}
</script>

<template>
    <Head title="Lista de Rochas" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Stones List
                </h2>
                <a :href="route('Rocha.create')" class="bg-[#9B9FB5] text-black px-4 py-2 rounded hover:bg-blue-700">
                    Cadastrar Rocha
                </a>
            </div>
        </template>

        <!-- Flash message -->
        <transition name="fade">
            <div v-if="popupVisible"
                class="fixed top-5 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-md shadow-md transition-opacity duration-500 ease-in-out">
                {{ successMessage }}
            </div>
        </transition>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <table class="min-w-full table-fixed divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="w-1/4 px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Foto</th>
                                    <th class="w-1/2 px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nome</th>
                                    <th class="w-1/4 px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr v-for="rocha in rochas.data" :key="rocha.id">
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm text-gray-900 dark:text-gray-100">
                                            <template v-if="!rocha.fotos || rocha.fotos.length === 0">
                                                <p>Não existe fotos cadastradas</p>
                                            </template>
                                            <template v-else>
                                                <img
                                                    :src="`/storage/${(rocha.fotos.find(f => f.capa) || rocha.fotos[0]).caminho}`"
                                                    alt="Foto da Rocha"
                                                    class="h-[144px] w-[128px] object-cover">
                                            </template>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-900 dark:text-gray-100">{{ rocha.nome }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a :href="route('Rocha.edit', rocha.id)" class="inline-flex items-center px-2 py-1 text-sm bg-[#9B9FB5] text-black dark:text-white hover:underline rounded">
                                                Editar
                                            </a>
                                            <button @click="deleteRocha(rocha.id)"
                                                class="inline-flex items-center px-2 py-1 bg-[#9B9FB5] text-sm text-red-600 dark:text-red-400 hover:underline rounded">
                                                Excluir
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Paginação -->
                        <div class="mt-4 flex justify-center">
                            <component
                                v-for="link in rochas.links"
                                :key="link.label"
                                :is="link.url ? 'router-link' : 'span'"
                                :to="link.url"
                                class="mx-1 px-3 py-1 rounded text-sm"
                                :class="{
                                    'bg-blue-600 text-white': link.active,
                                    'text-gray-500 dark:text-gray-300': !link.active && link.url,
                                    'text-gray-400': !link.url
                                }"
                                v-html="link.label"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
