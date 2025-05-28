<script setup>
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
</script>

<template>
  <div class="py-12">
    <div class="max-w-3xl mx-auto mt-8 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-6">Edição de Fotos</h2>

      <div class="mb-4">
        <h2>Foto Antiga</h2>
        <img :src="`/storage/${props.fotos.caminho}`" alt="Foto da Rocha" class="h-[144px] w-[128px] object-cover" />
      </div>

      <form @submit.prevent="submit" enctype="multipart/form-data">
        <div class="mb-4">
          <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Nova foto (Caso deseje alterar)
          </label>
          <input
            type="file"
            name="foto"
            id="foto"
            @change="atualizarCardCapa"
            class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-100 file:bg-gray-100 file:border-0 file:py-2 file:px-4 file:rounded file:text-sm file:font-semibold file:text-gray-700 file:cursor-pointer hover:file:bg-gray-200 dark:file:bg-gray-700 dark:file:text-gray-200 dark:hover:file:bg-gray-600"
          />
        </div>

        <div class="mb-4">
          <span class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Usar foto como capa?</span>
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
          <div
            v-for="(card, index) in cardsFotos"
            :key="index"
            class="card relative border border-gray-300 rounded-lg overflow-hidden"
          >
            <img :src="card.src" class="w-full h-full object-cover" />
            <div v-if="card.isCapa" class="capa-indicator">Capa</div>
          </div>
        </div>

        <div class="mt-4">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">ID da Rocha:</label>
          <input
            type="number"
            name="idRocha"
            v-model="form.idRocha"
            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">ID do Mineral:</label>
          <input
            type="number"
            name="idMineral"
            v-model="form.idMineral"
            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">ID da Jazida:</label>
          <input
            type="number"
            name="idJazida"
            v-model="form.idJazida"
            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>

        <div class="mt-6">
          <button
            type="submit"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 transition ease-in-out duration-150"
          >
            Atualizar
          </button>
        </div>
      </form>
    </div>
  </div>
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
</style>
