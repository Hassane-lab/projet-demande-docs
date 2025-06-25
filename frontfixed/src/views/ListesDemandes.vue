<template>
  <div class="demande-list">
    <div v-for="demande in demandes" :key="demande.id" class="demande-card">
      <p><strong>Étudiant :</strong> {{ demande.user.email }}</p>
      <p><strong>Type de document :</strong> {{ demande.document_type.name }}</p>
      <p><strong>Description :</strong> {{ demande.description || 'Aucune' }}</p>
      <p>
        <strong>Statut :</strong>
        <span :class="['badge', mapStatutClass(demande.statut)]">
          {{ afficherStatut(demande.statut) }}
        </span>
      </p>

      <select v-model="demande.statut" class="select-statut">
        <option value="en_attente">en attente</option>
        <option value="acceptee">acceptee</option>
        <option value="refusee">refusee</option>
      </select>

      <textarea
        v-model="demande.commentaire"
        placeholder="Ajouter un commentaire"
        rows="3"
        class="textarea-longue"
      ></textarea>

      <button class="save-button" @click="enregistrer(demande)">Enregistrer</button>
    </div>

    <div v-if="showToast" class="toast">Modification enregistrée !</div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useAuthStore } from '@/stores/auth'

const demandes = ref([])
const showToast = ref(false)
const auth = useAuthStore()

async function chargerDemandes() {
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/demandes', {
      headers: { Authorization: `Bearer ${auth.token}` }
    })
    demandes.value = res.data
  } catch (err) {
    console.error("Erreur lors du chargement des demandes :", err)
  }
}

async function enregistrer(demande) {
  try {
    const token = localStorage.getItem('token');
    console.log('Token utilisé :', token);
    console.log('Données envoyées :', demande);

    const response = await axios.put(
      `http://127.0.0.1:8000/api/demandes/${demande.id}`,
      {
        statut: demande.statut,
        commentaire: demande.commentaire
      },
      {
        headers: {
          Authorization: `Bearer ${token}`
        }
      }
    );

    console.log('Réponse succès :', response.data);

    showToast.value = true;
    setTimeout(() => {
      showToast.value = false;
    }, 3000);
  } catch (error) {
    console.error('Erreur enregistrement :', error);

    if (error.response) {
      console.error('Détails réponse API :', error.response.data);
      alert(`Erreur API : ${JSON.stringify(error.response.data)}`);
    } else if (error.request) {
      console.error('Pas de réponse du serveur');
      alert('Pas de réponse du serveur');
    } else {
      console.error('Erreur de configuration :', error.message);
      alert(`Erreur : ${error.message}`);
    }
  }
}

// Mappe statut vers class CSS
function mapStatutClass(statut) {
  if (statut === 'en_attente') return 'badge-en-attente'
  if (statut === 'acceptee') return 'badge-acceptee'
  if (statut === 'refusee') return 'badge-refusee'
  return ''
}

// Mappe statut pour l’affichage lisible
function afficherStatut(statut) {
  if (statut === 'en_attente') return 'en attente'
  return statut
}

onMounted(chargerDemandes)
</script>

<style scoped>
.demande-card {
  background: #f9f9f9;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 15px;
  margin-bottom: 15px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.badge {
  padding: 3px 8px;
  border-radius: 4px;
  font-size: 0.85em;
  color: white;
}

.badge-en-attente {
  background-color: #f0ad4e;
}

.badge-acceptee {
  background-color: #5cb85c;
}

.badge-refusee {
  background-color: #d9534f;
}

.select-statut {
  width: 150px;
  margin-top: 5px;
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.textarea-longue {
  width: 100%;
  max-width: 500px;
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-top: 5px;
}

.save-button {
  background: #007bff;
  color: white;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  margin-top: 6px;
  cursor: pointer;
  transition: background 0.3s ease;
}

.save-button:hover {
  background: #0056b3;
}

.toast {
  position: fixed;
  top: 20px;
  right: 20px;
  background: #28a745;
  color: white;
  padding: 12px 20px;
  border-radius: 5px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
  opacity: 0;
  animation: fadeInOut 3s forwards;
}

@keyframes fadeInOut {
  0% {
    opacity: 0;
    transform: translateY(-10px);
  }
  10%,
  90% {
    opacity: 1;
    transform: translateY(0);
  }
  100% {
    opacity: 0;
    transform: translateY(-10px);
  }
}
</style>