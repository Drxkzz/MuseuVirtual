<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';

const form = reactive({
    nome: '',
    descricao: '',
    propriedades: '',
    fotos: [],
    capa_nome: ''
});

const fotoInput = ref(null);
const previewFotos = ref([]);

function handleFileChange(event) {
    const files = Array.from(event.target.files);
    form.fotos = files;
    previewFotos.value = files.map((file, index) => ({
        file,
        url: URL.createObjectURL(file),
        isCapa: false,
        name: file.name
    }));
    form.capa_nome = ''; // reset
}

function setCapa(index) {
    previewFotos.value.forEach((foto, i) => {
        foto.isCapa = i === index;
    });
    form.capa_nome = previewFotos.value[index].name;
}

function submitForm() {
    const payload = new FormData();
    payload.append('nome', form.nome);
    payload.append('descricao', form.descricao);
    payload.append('propriedades', form.propriedades);
    form.fotos.forEach(f => payload.append('foto[]', f));
    payload.append('capa_nome', form.capa_nome);

    router.post(route('minerais.store'), payload);
}
</script>

<template>
  <Head title="Cadastrar Mineral" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Cadastrar Mineral
      </h2>
    </template>

<!-- Formulário de Criação -->
    <form @submit.prevent="submitForm" enctype="multipart/form-data">
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
              <!-- Nome -->
              <div class="mb-4">
                <label for="nome" class="block font-medium">Nome</label>
                <input id="nome" v-model="form.nome" type="text" required class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:text-white rounded-md shadow-sm" />
              </div>

              <!-- Descrição -->
              <div class="mb-4">
                <label for="descricao" class="block font-medium">Descrição</label>
                <input id="descricao" v-model="form.descricao" type="text" required class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:text-white rounded-md shadow-sm" />
              </div>

              <!-- Propriedades -->
              <div class="mb-4">
                <label for="propriedades" class="block font-medium">Propriedades</label>
                <input id="propriedades" v-model="form.propriedades" type="text" required class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:text-white rounded-md shadow-sm" />
              </div>

              <div class="mb-4">
              <label for="foto" class="block font-medium">Fotos do mineral</label>
              <input ref="fotoInput" @change="handleFileChange" type="file" id="foto" multiple class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-100 file:bg-gray-100 file:border-0 file:py-2 file:px-4 file:rounded file:text-sm file:font-semibold file:text-gray-700 file:cursor-pointer hover:file:bg-gray-200 dark:file:bg-gray-700 dark:file:text-gray-200 dark:hover:file:bg-gray-600" />
              </div>
              <div v-if="previewFotos.length" class="mt-4 grid grid-cols-3 gap-4">
                  <div v-for="(foto, index) in previewFotos" :key="foto.url"
                      class="card cursor-pointer relative border border-gray-300 rounded-lg overflow-hidden aspect-w-3 aspect-h-4"
                      @click="setCapa(index)">
                      <img :src="foto.url" class="w-full h-full object-cover"/>
                      <div v-if="foto.isCapa" class="absolute top-2 left-2 bg-white px-2 py-1 text-xs font-semibold text-gray-800"> Capa </div>
                  </div>
              </div>
              <!-- Botão de Envio -->
              <div class="mt-6">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700"> Criar Rocha </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </AuthenticatedLayout>
</template>

<style scoped>
.card img {
    transition: transform 0.3s ease-in-out;
}

.card:hover img {
    transform: scale(1.05);
}

.card:hover {
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

@media (max-width: 768px) {
    .grid-cols-3 {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .grid-cols-3 {
        grid-template-columns: 1fr;
    }
}
</style>