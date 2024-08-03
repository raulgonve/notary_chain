<script setup>
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import { ref, computed } from "vue";

dayjs.extend(relativeTime);
const props = defineProps(["chirp"]);

// Construir la URL de la imagen desde el campo notary
const imageBaseUrl = "/storage/"; // Asegúrate de que el almacenamiento público está accesible desde esta URL
const imageUrl = computed(() => imageBaseUrl + props.chirp.notary);
</script>

<template>
  <div class="p-6 flex space-x-2 items-center">
    <img :src="imageUrl" alt="Vista previa del documento" class="thumbnail" />
    <div class="flex-1">
      <div class="flex justify-between items-center">
        <div class="flex items-center space-x-2">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 text-gray-600"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M9 12l2 2 4-4M7 20h10a2 2 0 002-2V6a2 2 0 00-2-2h-5.586a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 007.586 1H7a2 2 0 00-2 2v16a2 2 0 002 2z"
            />
          </svg>
          <span class="text-gray-800">{{ props.chirp.user.name }}</span>
          <small class="ml-2 text-sm text-gray-600">{{
            dayjs(props.chirp.created_at).fromNow()
          }}</small>
        </div>
      </div>
      <p class="text-lg text-gray-900">{{ props.chirp.document_id }}</p>
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
