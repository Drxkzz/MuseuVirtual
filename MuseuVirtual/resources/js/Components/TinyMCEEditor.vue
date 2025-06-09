<template>
  <div>
    <textarea :id="editorId"></textarea>
  </div>
</template>

<script setup>
import { onMounted, onBeforeUnmount, ref, watch } from "vue";

const props = defineProps({
  modelValue: String,
});
const emit = defineEmits(["update:modelValue"]);

const editorId = `tinymce-editor-${Math.floor(Math.random() * 100000)}`;
const editorInstance = ref(null);

function initTinyMCE() {
  window.tinymce.init({
    selector: `#${editorId}`,
    height: 300,
    menubar: false,
    plugins: "lists link image preview",
    toolbar:
      "undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    skin_url: "/tinymce/js/tinymce/skins/ui/oxide",
    content_css: "/tinymce/js/tinymce/skins/content/default/content.css",
    language: "pt_BR",
    // ATENÇÃO: O arquivo pt_BR.js precisa estar em /tinymce/js/tinymce/langs/ para o idioma funcionar corretamente
    language_url: "/tinymce/js/tinymce/langs/pt_BR.js",
    // Configuração para upload de imagens
    images_upload_url: "/upload", // Endpoint para upload de imagens
    images_upload_handler: function (blobInfo, success, failure) {
      const formData = new FormData();
      formData.append("file", blobInfo.blob(), blobInfo.filename());

      const tokenMeta = document.querySelector('meta[name="csrf-token"]');
      const token = tokenMeta ? tokenMeta.getAttribute("content") : "";

      fetch("/upload", {
        method: "POST",
        body: formData,
        headers: {
          "X-CSRF-TOKEN": token,
        },
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Erro no upload: " + response.status);
          }
          return response.json();
        })
        .then((data) => {
          if (data.location) {
            success(data.location);
          } else if (typeof failure === "function") {
            failure(data.error || "Erro ao fazer upload da imagem");
          }
        })
        .catch((error) => {
          if (typeof failure === "function") {
            failure("Erro ao fazer upload da imagem: " + error);
          }
        });
    },
    automatic_uploads: true,
    setup(editor) {
      editorInstance.value = editor;
      editor.on("init", () => {
        editor.setContent(props.modelValue || "");
      });
      editor.on("change keyup", () => {
        emit("update:modelValue", editor.getContent());
      });
    },
    file_picker_types: "image",
    file_picker_callback: function (callback, value, meta) {
      if (meta.filetype === "image") {
        // Abre o seletor de imagens em uma nova janela
        window.open("/image-picker", "Image Picker", "width=800,height=600");
        // Função global para receber a URL da imagem escolhida
        window.SetUrl = function (url) {
          callback(url, { alt: "" });
        };
      }
    },
  });
}

onMounted(() => {
  if (!window.tinymce) {
    const script = document.createElement("script");
    script.src = "/tinymce/js/tinymce/tinymce.min.js";
    script.onload = () => initTinyMCE();
    document.head.appendChild(script);
  } else {
    initTinyMCE();
  }
});

onBeforeUnmount(() => {
  if (editorInstance.value) {
    editorInstance.value.destroy();
  }
});
</script>
