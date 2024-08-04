<script setup>
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import { ref, computed } from "vue";

dayjs.extend(relativeTime);
const props = defineProps(["documento"]);

// Construir la URL de la imagen desde el campo notary
const imageBaseUrl = "/storage/"; // Asegúrate de que el almacenamiento público está accesible desde esta URL
const imageUrl = computed(() => imageBaseUrl + props.documento.ruta);
</script>

<template>
  <div class="p-6 flex space-x-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
    </svg>
    <div class="flex-1">
      <div class="flex justify-between items-center">
        <div class="flex items-center space-x-2">
          <span class="text-gray-800">{{ props.documento.user.name }}</span>
          <small class="ml-2 text-sm text-gray-600">{{
            dayjs(props.documento.created_at).fromNow()
          }}</small>
        </div>
      </div>
        <p class="mt-3 text-lg text-gray-900"><b>descripcion:</b> {{ props.documento.descripcion }}</p>
        <p class="text-lg text-gray-900"><b>document_id:</b> {{ props.documento.document_id.substring(0,50) }}</p>
        <p class="text-lg text-gray-900"><b>document hash:</b> {{ props.documento.document_hash.substring(0,50) }}</p>
        <p class="text-lg text-gray-900"><b>notary:</b> {{ props.documento.notary }}</p>
        <p class="text-lg text-gray-900"><b>txid:</b> <a :href="'https://sepolia.scrollscan.com/tx/' + props.documento.txid" v-text="'Ver en el Explorador'" target="blank"></a></p>
        <p class="text-lg text-gray-900"><b>preview:</b>  <img :src="imageUrl" alt="archivo" class="thumbnail" /></p>

    </div>
  </div>
</template>

<style scoped>
.hidden {
  display: none;
}

.thumbnail {
  width: 50px; /* Ajusta el tamaño de la miniatura */
  height: 50px; /* Asegúrate de que la altura coincida */
  border-radius: 5%; /* Bordes circulares */
  object-fit: cover; /* Asegura que la imagen se ajuste y recorte bien */
}

.file-upload-container {
  display: flex;
  align-items: center;
}

.file-input {
  display: none;
}

.file-upload-label {
  display: inline-block;
  padding: 0.1em 1em;
  color: white;
  background-color: #007bff;
  border-radius: 0.1em;
  cursor: pointer;
  margin-right: 1em;
}

.file-upload-label:hover {
  background-color: #0056b3;
}

.file-upload-text {
  font-size: 1em;
}
</style>
