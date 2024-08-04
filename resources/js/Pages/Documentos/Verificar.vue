<script setup>
import { ref } from "vue";
import { ethers } from "ethers";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import LoadingModal from "@/Components/LoadingModal.vue";
import { useForm, Head } from "@inertiajs/vue3";

const verificationForm = useForm({
  file: null,
  verificationResult: null,
  verificationSuccess: false,
});

const fileName = ref("");
const verificationFileName = ref("");
const contractAddress = "0xB45bc0526137372718ad271eD3c816b77526ebe9"; // Dirección del contrato
const contractABI = [
  "function issueSBT(bytes32 documentHash, bytes32 documentID, address notary) public",
  "function verifySBT(bytes32 documentHash) public view returns (bool, (bytes32 documentHash, bytes32 documentID, uint256 timestamp, address notary))"
];

const message = ref(null);  // Variable para almacenar mensajes de éxito o error
const loading = ref(false);  // Variable para controlar la visibilidad del modal

const handleFileUpload = (event) => {
  form.file = event.target.files[0];
  fileName.value = form.file ? form.file.name : "";
};

const handleVerificationFileUpload = (event) => {
  verificationForm.file = event.target.files[0];
  verificationFileName.value = verificationForm.file ? verificationForm.file.name : "";
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

const verifySBT = async () => {
  try {
    loading.value = true; // Mostrar el modal de carga
    const documentHash = await calculateFileHash(verificationForm.file);

    const provider = new ethers.BrowserProvider(window.ethereum);
    const contract = new ethers.Contract(contractAddress, contractABI, provider);

    const [success, sbt] = await contract.verifySBT(documentHash);
    verificationForm.verificationSuccess = success;
    verificationForm.verificationResult = {
      documentHash: sbt.documentHash,
      documentID: sbt.documentID,
      timestamp: Number(sbt.timestamp), // Convertir BigInt a number usando Number()
      notary: sbt.notary
    };
    loading.value = false; // Ocultar el modal de carga
    console.log("SBT verificado:", sbt);
  } catch (error) {
    loading.value = false; // Ocultar el modal de carga
    console.error("Error verificando el SBT:", error);
  }
};
</script>

<template>
  <Head title="Verificar Documentos" />

  <AuthenticatedLayout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
      <!-- Modal de carga -->
      <LoadingModal :visible="loading" />

      <!-- Formulario para verificar SBT -->
      <form @submit.prevent="verifySBT" class="mt-10">
        <div class="file-upload-container mt-4">
          <input
            type="file"
            @change="handleVerificationFileUpload"
            ref="verificationFileInput"
            id="verificationFileInput"
            class="file-input block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
          />
          <label class="file-upload-label" for="verificationFileInput">Elegir archivo para verificar</label>
          <span class="file-upload-text">{{ verificationFileName || "Ningún archivo seleccionado" }}</span>
        </div>
        <InputError :message="verificationForm.errors.file" class="mt-2" />

        <PrimaryButton class="mt-4">Verificar Documento</PrimaryButton>
      </form>

      <div v-if="verificationForm.verificationResult && verificationForm.verificationSuccess" class="mt-6 bg-white shadow-sm rounded-lg p-4">
        <h3 class="text-lg font-semibold">Verificación Exitosa:</h3>
        <p><strong>Document Hash:</strong> {{ verificationForm.verificationResult.documentHash }}</p>
        <p><strong>Document ID:</strong> {{ verificationForm.verificationResult.documentID }}</p>
        <p><strong>Timestamp:</strong> {{ new Date(verificationForm.verificationResult.timestamp * 1000).toLocaleString() }}</p>
        <p><strong>Notary Address:</strong> {{ verificationForm.verificationResult.notary }}</p>
      </div>
      <div v-if="verificationForm.verificationResult && !verificationForm.verificationSuccess" class="mt-6 bg-white shadow-sm rounded-lg p-4">
        <h3 class="text-lg font-semibold">Verificación fallida: No se encontró un SBT para este archivo.</h3>
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
