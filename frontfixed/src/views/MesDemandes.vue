<template>
  <div class="mes-demandes">
    <h2>Mes demandes</h2>

    <div v-if="demandes.length === 0">
      <p>Aucune demande pour le moment.</p>
    </div>

    <ul v-else>
      <li v-for="demande in demandes" :key="demande.id">
        <strong>
          <span v-if="demande.document_type">
            {{ demande.document_type.name }}
          </span>
          <span v-else>
            Type inconnu
          </span>
        </strong>
        —
        <span v-if="demande.description">
          {{ demande.description }}
        </span>
        <span v-else>
          Aucune description
        </span>
        —
        <span :class="['statut', demande.statut]">
          Statut : {{ demande.statut }}
        </span>

        <div v-if="demande.commentaire" class="commentaire">
          📝 Commentaire : {{ demande.commentaire }}
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios'

const demandes = ref([])

onMounted(async () => {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/demandes', {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    })
    demandes.value = response.data
  } catch (error) {
    console.error('Erreur lors de la récupération des demandes :', error)
  }
})
</script>

<style scoped>
.mes-demandes {
  max-width: 800px;
  margin: auto;
  padding: 20px;
}
h2 {
  margin-bottom: 20px;
  color: #1e1e1e;
}
ul {
  list-style: none;
  padding: 0;
}
li {
  background: #f9f9f9;
  padding: 12px 18px;
  margin-bottom: 10px;
  border-radius: 6px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}
.statut {
  font-weight: bold;
  padding: 4px 10px;
  border-radius: 4px;
  margin-left: 8px;
}
.statut.en\ attente {
  background-color: #ffe5b4;
  color: #856404;
}
.statut.acceptée {
  background-color: #d4edda;
  color: #155724;
}
.statut.refusée {
  background-color: #f8d7da;
  color: #721c24;
}
.commentaire {
  margin-top: 6px;
  font-style: italic;
  color: #555;
}
</style>