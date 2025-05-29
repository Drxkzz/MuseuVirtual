<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  rochas: Array,
  minerais: Array,
  jazidas: Array
});

const previewCards = ref([])
const capaNome = ref('')

const form = useForm({
  foto: [],
  capa_nome: '',
  idRocha: '',
  idMineral: '',
  idJazida: ''
})

function handleFileChange(e) {
  const files = Array.from(e.target.files)
  previewCards.value = files.map(file => ({
    file,
    src: URL.createObjectURL(file),
    isCapa: false
  }))
  form.foto = files
  form.capa_nome = ''
}

function setCapa(fileName) {
  form.capa_nome = fileName
  previewCards.value.forEach(card => card.isCapa = card.file.name === fileName)
}

function submit() {
  form.post(route('fotos-store'), {
    forceFormData: true
  })
}
</script>

<template>
  <Head title="Cadastro de fotos" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Cadastro de fotos
      </h2>
    </template>

    <div class="py-12">
      <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto mt-2 p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md">
          <form @submit.prevent="submit" class="space-y-6" enctype="multipart/form-data">

            <div>
              <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fotos</label>
              <input type="file" multiple @change="handleFileChange"
                     class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-100 file:bg-gray-100 file:border-0 file:py-2 file:px-4 file:rounded file:text-sm file:font-semibold file:text-gray-700 file:cursor-pointer hover:file:bg-gray-200 dark:file:bg-gray-700 dark:file:text-gray-200 dark:hover:file:bg-gray-600" />
            </div>

            <div class="mt-4 grid grid-cols-3 gap-4">
              <div v-for="(card, index) in previewCards" :key="index"
                   class="card cursor-pointer relative border border-gray-300 rounded-lg overflow-hidden aspect-w-3 aspect-h-4"
                   @click="setCapa(card.file.name)">
                <img :src="card.src" class="w-full h-full object-cover" />
                <div v-if="card.isCapa"
                     class="absolute top-2 left-2 bg-white px-2 py-1 text-xs font-semibold text-gray-800">
                  Capa
                </div>
              </div>
            </div>

            <input type="hidden" name="capa_nome" :value="form.capa_nome">

            <div>
              <label for="idRocha" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rocha</label>
              <select v-model="form.idRocha" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg py-2 px-3">
                <option value="">Escolha uma rocha...</option>
                <option v-for="rocha in props.rochas" :key="rocha.id" :value="rocha.id">{{ rocha.nome }}</option>
              </select>
            </div>

            <div>
              <label for="idMineral" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mineral</label>
              <select v-model="form.idMineral" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg py-2 px-3">
                <option value="">Escolha um mineral...</option>
                <option v-for="mineral in props.minerais" :key="mineral.id" :value="mineral.id">{{ mineral.nome }}</option>
              </select>
            </div>

            <div>
              <label for="idJazida" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jazida</label>
              <select v-model="form.idJazida" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg py-2 px-3">
                <option value="">Escolha uma jazida...</option>
                <option v-for="jazida in props.jazidas" :key="jazida.id" :value="jazida.id">{{ jazida.localizacao }}</option>
              </select>
            </div>

            <div>
              <button type="submit"
                      class="w-full md:w-auto px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                Salvar Foto
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.card:hover img {
  transform: scale(1.05);
  transition: transform 0.3s ease-in-out;
}
</style>
