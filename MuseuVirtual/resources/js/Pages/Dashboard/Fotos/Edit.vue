<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'

const props = defineProps({
    fotos: Object,
})

const previewFoto = ref(null)
const novaFoto = ref(null)
const cardsFotos = ref([])
const capaValue = ref(props.fotos.capa)

const form = useForm({
    _method: 'put',
    foto: null,
    capa: capaValue.value,
    idRocha: props.fotos.idRocha,
    idMineral: props.fotos.idMineral,
    idJazida: props.fotos.idJazida,
})

const submit = () => {
    form.post(route('fotos-update', props.fotos.id), {
        forceFormData: true,
    })
}

const atualizarCardCapa = (e) => {
    const file = e.target.files[0]
    if (!file) return

    form.foto = file
    previewFoto.value = URL.createObjectURL(file)

    cardsFotos.value = [
        {
            src: previewFoto.value,
            isCapa: form.capa === 1,
        },
    ]
}


const mostrarModalImagem = ref(false)
const anotacoes = ref([])

const abrirModalImagem = () => {
    mostrarModalImagem.value = true
}

const fecharModalImagem = () => {
    mostrarModalImagem.value = false
}



const imagemRef = ref(null)

const adicionarAnotacao = (e) => {
    const img = imagemRef.value
    const bounds = img.getBoundingClientRect()

    const x = e.clientX - bounds.left
    const y = e.clientY - bounds.top

    const texto = prompt("Digite o texto da anotação:")
    if (texto) {
        anotacoes.value.push({
            x,
            y,
            texto,
            mostrarTexto: true
        })
    }
}

const toggleAnotacao = (index) => {
    anotacoes.value[index].mostrarTexto = !anotacoes.value[index].mostrarTexto
}

const editarAnotacao = (index) => {
    const novaMensagem = prompt("Editar anotação:", anotacoes.value[index].texto)
    if (novaMensagem !== null && novaMensagem.trim() !== '') {
        anotacoes.value[index].texto = novaMensagem.trim()
    }
}

const removerAnotacao = (index) => {
    if (confirm("Deseja remover esta anotação?")) {
        anotacoes.value.splice(index, 1)
    }
}
</script>


<template>
    <AuthenticatedLayout>
        <Head title="Fotos " />
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Editar Foto
                </h2>
                <a :href="route('jazidas.index')"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Voltar
                </a>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-3xl mx-auto mt-8 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                        Edição de Fotos
                    </h2>
                    <a @click='abrirModalImagem' 
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Adicionar Informações Imagem
                    </a>
                </div>

                <div class="mb-4">
                    <h2>Foto Antiga</h2>
                    <img :src="`/storage/${props.fotos.caminho}`" alt="Foto da Rocha"
                        class="h-[144px] w-[128px] object-cover" />
                </div>

                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nova foto (Caso deseje alterar)
                        </label>
                        <input type="file" name="foto" id="foto" @change="atualizarCardCapa"
                            class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-100 file:bg-gray-100 file:border-0 file:py-2 file:px-4 file:rounded file:text-sm file:font-semibold file:text-gray-700 file:cursor-pointer hover:file:bg-gray-200 dark:file:bg-gray-700 dark:file:text-gray-200 dark:hover:file:bg-gray-600" />
                    </div>

                    <div class="mb-4">
                        <span class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Usar foto como
                            capa?</span>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="capa" value="1" v-model="form.capa" class="text-blue-600" />
                                <span class="text-gray-700 dark:text-gray-300">Sim</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="capa" value="0" v-model="form.capa" class="text-blue-600" />
                                <span class="text-gray-700 dark:text-gray-300">Não</span>
                            </label>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-3 gap-4" id="cardsFotos">
                        <div v-for="(card, index) in cardsFotos" :key="index"
                            class="card relative border border-gray-300 rounded-lg overflow-hidden">
                            <img :src="card.src" class="w-full h-full object-cover" />
                            <div v-if="card.isCapa" class="capa-indicator">Capa</div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">ID da Rocha:</label>
                        <input type="number" name="idRocha" v-model="form.idRocha"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">ID do Mineral:</label>
                        <input type="number" name="idMineral" v-model="form.idMineral"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">ID da Jazida:</label>
                        <input type="number" name="idJazida" v-model="form.idJazida"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 transition ease-in-out duration-150">
                            Atualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div v-if="mostrarModalImagem"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white p-4 rounded relative w-[90%] max-w-4xl max-h-[90%] overflow-auto">
                <!-- Botão Fechar -->
                <button @click="fecharModalImagem"
                        class="absolute top-2 right-2 text-gray-700 hover:text-red-600">
                    ✕
                </button>
    
                <h3 class="text-lg font-semibold mb-4">Clique na imagem para adicionar informações</h3>
    
                <!-- Container da imagem -->
                <div class="relative">
                    <img :src="`/storage/${props.fotos.caminho}`" 
                        @click="adicionarAnotacao"
                        ref="imagemRef"
                        class="w-full h-auto cursor-crosshair" />
    
                    <div v-for="(anotacao, index) in anotacoes"
                        :key="index"
                        :style="{
                            position: 'absolute',
                            top: anotacao.y + 'px',
                            left: anotacao.x + 'px',
                            transform: 'translate(-50%, -50%)'
                        }"
                        class="absolute z-10">

                        <div @click="toggleAnotacao(index)"
                            class="w-4 h-4 bg-red-600 rounded-full shadow cursor-pointer border-2 border-white animate-pulse">
                        </div>

                        <div v-if="anotacao.mostrarTexto"
                            class="absolute mt-2 left-1/2 -translate-x-1/2 bg-white text-black text-sm p-2 rounded shadow-lg z-20 max-w-[200px] w-max min-w-[100px]">
                            <p class="mb-2 break-words">{{ anotacao.texto }}</p>
                            <div class="flex justify-between space-x-2 text-xs">
                                <button @click.stop="editarAnotacao(index)" class="text-blue-600 hover:underline">Editar</button>
                                <button @click.stop="removerAnotacao(index)" class="text-red-600 hover:underline">Excluir</button>
                            </div>
                        </div>
                    </div>

                </div>
    
                <!-- Botão de salvar -->
                <div class="mt-4 flex justify-end">
                    <button @click="salvarAnotacoes"
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Salvar Anotações
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.card {
    position: relative;
    border: 2px solid transparent;
    transition: transform 0.3s ease-in-out, border-color 0.3s;
    cursor: pointer;
}

.card:hover img {
    transform: scale(1.05);
}

.card.selected {
    border-color: #4c51bf;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.3);
}

.capa-indicator {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    background-color: white;
    color: #1f2937;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

/* Animação de pulsar (já usada no pin) */
@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.3); opacity: 0.7; }
    100% { transform: scale(1); opacity: 1; }
}

.animate-pulse {
    animation: pulse 1.5s infinite;
}

</style>
