<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Inertia } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';

const nome = ref('');
const descricao = ref('');
const propriedades = ref('');
const fotos = ref(null);

function onFileChange(event) {
  fotos.value = event.target.files;
}

function submitForm() {
  const formData = new FormData();
  formData.append('nome', nome.value);
  formData.append('descricao', descricao.value);
  formData.append('propriedades', propriedades.value);

  if (fotos.value) {
    for (let i = 0; i < fotos.value.length; i++) {
      formData.append('foto[]', fotos.value[i]);
    }
  }
  
  Inertia.post(route('minerais.store'), formData);
}
</script>

<template>
  <Head title="Cadastrar Mineral" />
  <AuthenticatedLayout>
    <!-- Cabeçalho do Layout -->
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
                <label for="nome" class="block mt-1 w-full">Nome</label>
                <input
                  type="text"
                  id="nome"
                  name="nome"
                  v-model="nome"
                  class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                  required
                />
              </div>

              <!-- Descrição -->
              <div class="mb-4">
                <label for="descricao" class="block mt-1 w-full">Descrição</label>
                <textarea
                  id="descricao"
                  name="descricao"
                  rows="4"
                  v-model="descricao"
                  class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                  required
                ></textarea>
              </div>

              <!-- Propriedades -->
              <div class="mb-4">
                <label for="propriedades" class="block mt-1 w-full">Propriedades</label>
                <textarea
                  id="propriedades"
                  name="propriedades"
                  rows="4"
                  v-model="propriedades"
                  class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                  required
                ></textarea>
              </div>

              <!-- Fotos do Mineral -->
              <div class="mb-4">
                <label for="foto" class="block mt-1 w-full">Foto(s) do Mineral</label>
                <input
                  type="file"
                  id="foto"
                  name="foto[]"
                  multiple
                  @change="onFileChange"
                  class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                />
              </div>

              <!-- Botão de Envio -->
              <div class="flex items-center justify-end mt-6">
                <PrimaryButton type="submit" class="btn btn-primary">
                  Criar
                </PrimaryButton>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </AuthenticatedLayout>
</template>