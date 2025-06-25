<template>
  <div class="form-container">
    <h2>Nouvelle demande</h2>

    <div v-if="error" class="error">{{ error }}</div>
    <div v-if="success" class="success">{{ success }}</div>

    <form @submit.prevent="envoyerDemande">
      <label for="type">Type de document</label>
      <select v-model="form.document_type_id" required>
        <option disabled value="">-- Choisir --</option>
        <option v-for="type in documentTypes" :key="type.id" :value="type.id">
          {{ type.name }}
        </option>
      </select>

      <label for="description">Motif (optionnel)</label>
      <input type="text" v-model="form.description" placeholder="Ex : Justificatif d'absence" />

      <button type="submit">Envoyer la demande</button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const form = ref({
  document_type_id: '',
  description: '',
})
const documentTypes = ref([])
const error = ref('')
const success = ref('')

const chargerTypesDocument = async () => {
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/document-types', {
      headers: { Authorization: `Bearer ${auth.token}` },
    })
    documentTypes.value = res.data
  } catch (err) {
    error.value = 'Erreur lors du chargement des types de document'
    console.error(err)
  }
}

const envoyerDemande = async () => {
  try {
    await axios.post('http://127.0.0.1:8000/api/demandes', form.value, {
      headers: { Authorization: `Bearer ${auth.token}` },
    })
    success.value = 'Demande envoyée avec succès !'
    error.value = ''
    form.value.document_type_id = ''
    form.value.description = ''
  } catch (err) {
    error.value = "Échec de l'envoi de la demande"
    success.value = ''
    console.error(err)
  }
}

onMounted(chargerTypesDocument)
</script>

<style scoped>
.form-container {
  max-width: 600px;
  margin: 30px auto;
  padding: 20px;
  background: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

h2 {
  text-align: center;
  margin-bottom: 20px;
}

label {
  display: block;
  margin-top: 15px;
  font-weight: bold;
}

input,
select {
  width: 100%;
  padding: 10px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  margin-top: 20px;
  width: 100%;
  padding: 10px;
  background: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background: #0056b3;
}

.error {
  color: red;
  background: #ffe5e5;
  padding: 8px;
  border-radius: 4px;
  margin-bottom: 10px;
}

.success {
  color: green;
  background: #e5ffe5;
  padding: 8px;
  border-radius: 4px;
  margin-bottom: 10px;
}
</style>