<script setup>
import { ref } from "vue";
import { ethers } from "ethers";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Documento from "@/Components/Documento.vue";
import LoadingModal from "@/Components/LoadingModal.vue";
import { useForm, Head } from "@inertiajs/vue3";

defineProps(['documentos']);

const form = useForm({
  descripcion: "",
  document_id: "",
  file: null,
  notary: null,
  document_hash: null,
  txid: null,
});

const fileName = ref("");
const contractAddress = "0xB45bc0526137372718ad271eD3c816b77526ebe9"; // Dirección del contrato
const contractABI = [
  "function issueSBT(bytes32 documentHash, bytes32 documentID, address notary) public",
  "function verifySBT(bytes32 documentHash) public view returns (bool, (bytes32 documentHash, bytes32 documentID, uint256 timestamp, address notary))"
];

const respuesta = ref('');  // Variable para almacenar mensajes de éxito o error
const loading = ref(false);  // Variable para controlar la visibilidad del modal

const handleFileUpload = (event) => {
  form.file = event.target.files[0];
  fileName.value = form.file ? form.file.name : "";
};


const submitForm = async () => {
  const formData = new FormData();
  formData.append("descripcion", form.descripcion);
  if (form.file) {
    formData.append("file", form.file);
  }

  loading.value = true; // Mostrar el modal de carga

  const success = await issueSBT(form.descripcion, form.file);

  loading.value = false; // Ocultar el modal de carga

  if (success) {
    form.post(route("documentos.store"), {
      onSuccess: async () => {
        form.reset();
        respuesta.value = "Documento notariado con éxito.";
      },
      forceFormData: true,
      data: formData,
    });
  }
};

const calculateFileHash = (file) => {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = () => {
      const arrayBuffer = reader.result;
      const bytes = new Uint8Array(arrayBuffer);
      const hash = ethers.keccak256(bytes);
      resolve(hash);
    };
    reader.onerror = () => {
      reject("Error reading file");
    };
    reader.readAsArrayBuffer(file);
  });
};

const issueSBT = async (message, file) => {
  try {
    console.log("Iniciando la conexión al proveedor...");
    await window.ethereum.request({ method: 'eth_requestAccounts' }); // Solicitar acceso a cuentas
    const provider = new ethers.BrowserProvider(window.ethereum);
    console.log("Proveedor configurado:", provider);

    const signer = await provider.getSigner();
    console.log("Signer obtenido:", signer);

    const contract = new ethers.Contract(contractAddress, contractABI, signer);
    console.log("Contrato instanciado:", contract);

    const userAddress = await signer.getAddress();
    // actualizar en el campo notary
    form.notary = userAddress;
    console.log("Dirección del usuario:", userAddress);

    const documentHash = await calculateFileHash(file);
    form.document_hash = documentHash;

    const documentID = ethers.keccak256(ethers.toUtf8Bytes(fileName.value));

    const tx = await contract.issueSBT(documentHash, documentID, userAddress);
    await tx.wait();
    form.txid = tx.hash;

    // console.log("Token emitido con éxito:", tx);
    return true;
  } catch (error) {
    loading.value = false; // Ocultar el modal de carga
    // console.error("Error emitiendo el token:", error);
    respuesta.value = `Error emitiendo el token: ${error.reason || error.message || error.data.message}`;
    return false;
  }
};

</script>

<template>
  <Head title="Documentos" />

  <AuthenticatedLayout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
      <!-- Formulario para emitir SBT -->
      <form @submit.prevent="submitForm">
        <input
          v-model="form.descripcion"
          placeholder="Introduce una Breve descripción del Documento a Notariar"
          class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2"
        >
        <InputError :message="form.errors.descripcion" class="mt-2" />

        <!-- input document_id -->
        <input
          v-model="form.document_id"
          type="text"
          placeholder="Introduce el ID del Documento"
          class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mb-2" />
        <InputError :message="form.errors.document_id" class="mt-2" />

        <div class="file-upload-container mt-4">
          <input
            type="file"
            @change="handleFileUpload"
            ref="fileInput"
            id="fileInput"
            class="file-input block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
          />
          <label class="file-upload-label" for="fileInput">Elegir archivo</label>
          <span class="file-upload-text">{{ fileName || "Ningún archivo seleccionado" }}</span>
        </div>
        <InputError :message="form.errors.file" class="mt-2" />

        <PrimaryButton class="mt-8">Notariar Documento</PrimaryButton>
      </form>

      <!-- Mensaje de éxito o error -->
      <div v-if="respuesta" class="mt-4 p-2 rounded bg-white text-red-500">
        {{ respuesta.substring(0, 120) }}
      </div>

      <!-- Modal de carga -->
      <LoadingModal :visible="loading" />

      <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
        <h2 v-if="documentos" class="mb-3">Lista de Documentos Cargados:</h2>
        <Documento v-for="documento in documentos" :key="documento.id" :documento="documento" />
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
