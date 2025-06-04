<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';

const props = defineProps({
  minerais: {
    type: Array,
    default: () => [],
  },
});

const minerais = props.minerais;

const page = usePage();
const successMessage = computed(() => page.props?.flash?.success ?? null);

onMounted(() => {
  console.log(minerais.length);
});

function submitDelete(id) {
  if (confirm('Tem certeza que deseja excluir este mineral?')) {
    router.delete(route('minerais.destroy', id));
  }
}
</script>

<template>
  <Head title="Lista de Minerais" />
  <AuthenticatedLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <!-- Cabeçalho -->
            <div class="flex justify-between mb-4">
              <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Lista de Minerais
              </h2>
              <a
                :href="route('minerais.create')"
                class="bg-gray-100 inline-block text-black px-4 bg-blue-600 rounded hover:bg-blue-700"
              >
                Cadastrar Mineral
              </a>
            </div>

            <!-- Mensagem de sucesso -->
            <div v-if="successMessage" class="mb-4 p-4 bg-green-100 text-green-800 rounded">
              {{ successMessage }}
            </div>

            <!-- Tabela de Minerais -->
            <div v-if="minerais.length > 0">
              <table class="min-w-full table-fixed divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                  <tr>
                    <th class="w-1/4 px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                      Foto
                    </th>
                    <th class="w-1/4 px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                      Nome
                    </th>
                    <th class="w-1/4 px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                      Ações
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                  <tr
                    v-for="mineral in minerais"
                    :key="mineral.id"
                    class="hover:bg-gray-50 dark:hover:bg-gray-700"
                  >
                    <td class="px-6 py-4 text-center">
                      <p v-if="!mineral.fotos || mineral.fotos.length === 0">
                        Não existe fotos cadastradas
                      </p>
                      <img
                        v-else
                        :src="`/storage/${mineral.fotos[0].caminho}`"
                        alt="Foto dos Minerais"
                        class="h-[144px] w-[128px] object-cover"
                      />
                    </td>
                    <td class="px-6 py-4 text-center">
                      {{ mineral.nome }}
                    </td>
                    <td class="px-6 py-4 text-center">
                      <div class="flex items-center justify-center gap-2">
                        <a
                          :href="route('minerais.edit', mineral.id)"
                          class="inline-flex items-center px-2 py-1 text-sm text-blue-600 dark:text-blue-400 hover:underline"
                        >
                          Editar
                        </a>
                        <form :action="route('minerais.destroy', mineral.id)" method="POST" @submit.prevent="submitDelete(mineral.id)">
                          <input type="hidden" name="_method" value="DELETE" />
                          <button type="submit" class="inline-flex items-center px-2 py-1 text-sm text-red-600 dark:text-red-400 hover:underline">
                            Excluir
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Caso não haja minerais cadastrados -->
            <p v-else class="text-center text-gray-600 dark:text-gray-300">
              Nenhum mineral cadastrado.
            </p>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>