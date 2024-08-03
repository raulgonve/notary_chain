<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, Head } from "@inertiajs/vue3";
import Chirp from "@/Components/Chirp.vue";
import { ref } from "vue";

defineProps(["chirps"]);

const form = useForm({
  message: "",
  file: null,
});

const fileName = ref("");

const handleFileUpload = (event) => {
  form.file = event.target.files[0];
  fileName.value = form.file ? form.file.name : "";
};

const submitForm = () => {
  const formData = new FormData();
  formData.append("message", form.message);
  if (form.file) {
    formData.append("file", form.file);
  }

  form.post(route("chirps.store"), {
    onSuccess: () => form.reset(),
    forceFormData: true,
    data: formData,
  });
};
</script>

<template>
  <Head title="Chirps" />

  <AuthenticatedLayout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
      <form @submit.prevent="submitForm">
        <textarea
          v-model="form.message"
          placeholder="Introduce una Breve descripción del Documento a Notariar"
          class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        ></textarea>
        <InputError :message="form.errors.message" class="mt-2" />

        <div class="file-upload-container mt-4">
          <input
            type="file"
            @change="handleFileUpload"
            ref="fileInput"
            id="fileInput"
            class="file-input block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
          />
          <label class="file-upload-label" for="fileInput"
            >Elegir archivo</label
          >
          <span class="file-upload-text">{{
            fileName || "Ningún archivo seleccionado"
          }}</span>
        </div>
        <InputError :message="form.errors.file" class="mt-2" />

        <PrimaryButton class="mt-8">Notariar Documento</PrimaryButton>
      </form>
      <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
        <Chirp v-for="chirp in chirps" :key="chirp.id" :chirp="chirp" />
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.hidden {
  display: none;
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
  padding: 0.5em 1em;
  color: white;
  background-color: #007bff;
  border-radius: 0.25em;
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
