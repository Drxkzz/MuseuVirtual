<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, watch, nextTick } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  fotos: Object,
});

const previewFoto = ref(null);
const capaValue = ref(props.fotos.capa);

const form = useForm({
  _method: 'put',
  foto: null,
  capa: capaValue.value,
  idRocha: props.fotos.idRocha,
  idMineral: props.fotos.idMineral,
  idJazida: props.fotos.idJazida,
});

const submit = () => {
  form.post(route('fotos-update', props.fotos.id), {
    forceFormData: true,
  });
};

const atualizarCardCapa = (e) => {
  const file = e.target.files[0];
  if (!file) return;
  form.foto = file;
  previewFoto.value = URL.createObjectURL(file);
};

// ---------- CONTROLE DE ANOTAÇÕES ----------

const mostrarModalImagem = ref(false);

const anotacoes = ref(
  (props.fotos.anotacoes || []).map(a => ({
    id: a.id,
    xOriginal: a.x,
    yOriginal: a.y,
    x: 0,
    y: 0,
    texto: a.texto,
    mostrarTexto: true,
  }))
);

const anotacoesParaExcluir = ref([]);

const imagemRef = ref(null);

const abrirModalImagem = () => {
  mostrarModalImagem.value = true;
  nextTick().then(() => ajustarPosicoes());
};

const fecharModalImagem = () => {
  mostrarModalImagem.value = false;
};

const ajustarPosicoes = () => {
  if (!imagemRef.value) return;

  const img = imagemRef.value;
  const naturalWidth = img.naturalWidth;
  const naturalHeight = img.naturalHeight;

  const displayedWidth = img.clientWidth;
  const displayedHeight = img.clientHeight;

  const scaleX = displayedWidth / naturalWidth;
  const scaleY = displayedHeight / naturalHeight;

  anotacoes.value.forEach((anotacao) => {
    anotacao.x = anotacao.xOriginal * scaleX;
    anotacao.y = anotacao.yOriginal * scaleY;
  });
};

window.addEventListener('resize', () => {
  ajustarPosicoes();
});

watch(imagemRef, async (newVal) => {
  if (!newVal) return;
  await nextTick();
  ajustarPosicoes();
});

const adicionarAnotacao = (e) => {
  if (!imagemRef.value) return;

  const bounds = imagemRef.value.getBoundingClientRect();
  const naturalWidth = imagemRef.value.naturalWidth;
  const naturalHeight = imagemRef.value.naturalHeight;

  const xExibido = e.clientX - bounds.left;
  const yExibido = e.clientY - bounds.top;

  const scaleX = naturalWidth / bounds.width;
  const scaleY = naturalHeight / bounds.height;

  const xNatural = xExibido * scaleX;
  const yNatural = yExibido * scaleY;

  const texto = prompt("Digite o texto da anotação:");
  if (texto && texto.trim() !== '') {
    anotacoes.value.push({
      id: null,
      xOriginal: xNatural,
      yOriginal: yNatural,
      x: xExibido,
      y: yExibido,
      texto: texto.trim(),
      mostrarTexto: true,
    });
  }
};

const toggleAnotacao = (index) => {
  anotacoes.value[index].mostrarTexto = !anotacoes.value[index].mostrarTexto;
};

const editarAnotacao = (index) => {
  const anotacao = anotacoes.value[index];
  const novoTexto = prompt("Editar anotação:", anotacao.texto);
  if (novoTexto !== null && novoTexto.trim() !== '') {
    anotacao.texto = novoTexto.trim();
  }
};

const removerAnotacao = (index) => {
  const anotacao = anotacoes.value[index];
  if (confirm("Deseja remover esta anotação?")) {
    if (anotacao.id) {
      anotacoesParaExcluir.value.push(anotacao.id);
    }
    anotacoes.value.splice(index, 1);
  }
};

const salvarAnotacoes = () => {
  const payload = anotacoes.value.map(a => ({
    id: a.id,
    x: a.xOriginal,
    y: a.yOriginal,
    texto: a.texto,
  }));

  router.post(route('fotos.anotacoes.store', props.fotos.id), {
    anotacoes: payload,
    deletadas: anotacoesParaExcluir.value,
  }, {
    preserveScroll: true,
    onSuccess: () => {
      mostrarModalImagem.value = false;
      anotacoesParaExcluir.value = [];
    },
  });
};

const calcularClassePosicaoTexto = (anotacao) => {
  if (!imagemRef.value) return 'texto-direita';

  const containerWidth = imagemRef.value.clientWidth;
  const boxMaxWidthPx = containerWidth * 0.4; // max width 40%
  const pinX = anotacao.x;

  if (pinX + 8 + boxMaxWidthPx < containerWidth) {
    return 'texto-direita';
  } else if (pinX > containerWidth * 0.3 && pinX < containerWidth * 0.7) {
    return 'texto-meio';
  } else {
    return 'texto-esquerda';
  }
};
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Editar Foto" />
    <div class="py-12">
      <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Edição de Fotos</h2>
          <button @click="abrirModalImagem" class="bg-blue-600 text-white px-4 py-2 rounded">Anotações</button>
        </div>

        <img :src="previewFoto || `/storage/${props.fotos.caminho}`" class="h-36 w-32 object-cover mb-4" />

        <form @submit.prevent="submit">
          <input type="file" @change="atualizarCardCapa" class="mb-4" />

          <div class="flex space-x-4 mb-4">
            <label><input type="radio" value="1" v-model="form.capa" /> Capa</label>
            <label><input type="radio" value="0" v-model="form.capa" /> Não capa</label>
          </div>

          <input type="number" v-model="form.idRocha" placeholder="ID Rocha" class="mb-2 w-full" />
          <input type="number" v-model="form.idMineral" placeholder="ID Mineral" class="mb-2 w-full" />
          <input type="number" v-model="form.idJazida" placeholder="ID Jazida" class="mb-4 w-full" />

          <button class="bg-indigo-600 text-white px-4 py-2 rounded">Atualizar</button>
        </form>
      </div>
    </div>

    <div
      v-if="mostrarModalImagem"
      class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
    >
      <div
        class="bg-white p-4 rounded w-[90%] max-w-4xl max-h-[90%] overflow-auto relative"
      >
        <button
          @click="fecharModalImagem"
          class="absolute top-2 right-2 text-3xl font-bold"
        >
          &times;
        </button>
        <h3 class="text-lg font-semibold mb-4">Clique na imagem para adicionar informações</h3>

        <div class="relative">
          <img
            :src="`/storage/${props.fotos.caminho}`"
            @click="adicionarAnotacao"
            ref="imagemRef"
            class="w-full cursor-crosshair"
          />

          <div
            v-for="(anotacao, index) in anotacoes"
            :key="anotacao.id ?? index"
            :style="{ top: anotacao.y + 'px', left: anotacao.x + 'px', position: 'absolute' }"
          >
            <div
              @click="toggleAnotacao(index)"
              class="w-4 h-4 bg-red-600 rounded-full cursor-pointer pulsante"
              title="Clique para mostrar/esconder texto"
            ></div>
            <div
              v-if="anotacao.mostrarTexto"
              :class="calcularClassePosicaoTexto(anotacao)"
            >
              <p>{{ anotacao.texto }}</p>
              <div class="flex justify-between text-xs mt-1">
                <button @click.stop="editarAnotacao(index)" class="text-blue-600 hover:underline">Editar</button>
                <button @click.stop="removerAnotacao(index)" class="text-red-600 hover:underline">Excluir</button>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-4 text-right">
          <button @click="salvarAnotacoes" class="bg-green-600 text-white px-4 py-2 rounded">Salvar</button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.bg-opacity-50 {
  backdrop-filter: blur(4px);
}

@keyframes pulse {
  0% {
    transform: scale(1);
    opacity: 1;
  }
  50% {
    transform: scale(1.5);
    opacity: 0.8;
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}

.pulsante {
  animation: pulse 2s infinite;
}

/* Caixa de texto das anotações */

.texto-direita,
.texto-esquerda {
  position: absolute;
  top: 100%;
  margin-top: 4px;
  z-index: 10;
  max-width: 40%;
  min-width: 120px;
  word-break: break-word;
  background: white;
  padding: 0.5rem;
  border-radius: 0.375rem;
  box-shadow: 0 2px 8px rgb(0 0 0 / 0.15);
}

.texto-direita {
  left: 8px;
}

.texto-esquerda {
  right: 8px;
  transform-origin: top right;
}

.texto-meio {
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-50%);
  margin-top: 4px;
  z-index: 10;
  max-width: 45%;
  min-width: 150px;
  word-break: break-word;
  background: white;
  padding: 0.5rem;
  border-radius: 0.375rem;
  box-shadow: 0 2px 8px rgb(0 0 0 / 0.15);
}
</style>
