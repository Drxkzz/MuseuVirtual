<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'

const props = defineProps({
    jazida: Object,
})

const form = useForm({
    localizacao: props.jazida.localizacao,
    descricao: props.jazida.descricao,
})

function submit() {
    form.put(route('jazidas.update', props.jazida.id))
}

onMounted(()=>{
    console.log(props.jazida)
})
</script>

<template>

    <Head title="Jazidas " />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Editar Jazida
                </h2>
                <a :href="route('jazidas.index')"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Voltar
                </a>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <form @submit.prevent="submit">
                            <!-- Localização -->
                            <div class="mb-4">
                                <InputLabel for="localizacao" value="Localização" />
                                <TextInput id="localizacao" v-model="form.localizacao" type="text"
                                    class="block mt-1 w-full" />
                                <span v-if="form.errors.localizacao" class="text-red-500 text-sm">{{
                                    form.errors.localizacao }}</span>
                            </div>

                            <!-- Descrição -->
                            <div class="mb-4">
                                <InputLabel for="descricao" value="Descrição" />
                                <textarea id="descricao" v-model="form.descricao" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 
                                dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 
                                focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                </textarea>
                                <span v-if="form.errors.descricao" class="text-red-500 text-sm">{{ form.errors.descricao
                                }}</span>
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Salvar Alterações
                                </PrimaryButton>
                            </div>
                        </form>

                        <!-- Fotos da Jazida -->
                        <div class="mt-6">
                            <h2 class="text-xl font-semibold">Fotos da Jazida</h2>
                            <div class="flex flex-wrap">
                                <p v-if="props.jazida.fotos.length === 0">Não há fotos cadastradas para esta jazida.</p>
                                <div v-else v-for="foto in props.jazida.fotos" :key="foto.id"
                                    class="p-2 border rounded-md mx-2">
                                    <img :src="`/storage/${foto.caminho}`" alt="Foto da Jazida"
                                        class="h-32 w-32 object-cover mb-2" />
                                    <div class="flex gap-2">
                                        <a :href="route('fotos-edit', foto.id)" class="text-blue-500">Editar</a>
                                        <form :action="route('fotos-destroy', foto.id)" method="POST"
                                            @submit.prevent="$inertia.delete(route('fotos-destroy', foto.id))">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="text-red-500"
                                                @click.prevent="$inertia.delete(route('fotos-destroy', foto.id))">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>