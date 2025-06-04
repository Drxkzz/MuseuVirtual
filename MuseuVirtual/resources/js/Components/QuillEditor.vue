<template>
  <div class="border border-gray-300 dark:border-gray-600 rounded-md overflow-hidden">
    <div ref="editor" :id="$attrs.id" :class="$attrs.class"></div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import Quill from 'quill'
import 'quill/dist/quill.snow.css'

const emit = defineEmits(['update:modelValue'])

const props = defineProps({
  modelValue: String,
  editorHeight: {
    type: String,
    default: '300px',
  },
})

defineOptions({ inheritAttrs: false })

const editor = ref(null)
let quillInstance

onMounted(() => {
  quillInstance = new Quill(editor.value, {
    theme: 'snow',
    placeholder: 'Digite aqui...',
    modules: {
      toolbar: {
        container: [
          ['bold', 'italic', 'underline'],
          ['image', 'code-block'],
          [{ list: 'ordered' }, { list: 'bullet' }],
        ],
        handlers: {
          image: function () {
            const input = document.createElement('input')
            input.setAttribute('type', 'file')
            input.setAttribute('accept', 'image/*')
            input.click()

            input.onchange = async () => {
              const file = input.files[0]
              const formData = new FormData()
              formData.append('image', file)

              try {
                const res = await axios.post('/upload-image', formData)
                const range = quillInstance.getSelection()
                quillInstance.insertEmbed(range.index, 'image', res.data.url)
              } catch (err) {
                alert('Erro ao fazer upload da imagem.')
              }
            }
          },
        },
      },
    },
  })

  quillInstance.on('text-change', () => {
    emit('update:modelValue', quillInstance.root.innerHTML)
  })

  // Preencher conteúdo inicial
  quillInstance.root.innerHTML = props.modelValue || ''
})
</script>

<style scoped>
.ql-editor {
  @apply min-h-[300px] max-h-[500px] overflow-y-auto p-4 text-gray-800 dark:text-white;
  line-height: 1.5;
}

/* Corrige visual de fundo em dark mode */
.ql-container {
  @apply bg-white dark:bg-gray-700;
}
</style>
