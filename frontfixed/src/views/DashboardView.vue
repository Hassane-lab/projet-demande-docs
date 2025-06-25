<template>
  <div class="dashboard container">
    <h2>Tableau de bord de l’agent</h2>

    <!-- Statistiques -->
    <div class="stats-container">
      <div class="stat-card total">
        <p class="label">Total</p>
        <p class="value">{{ stats.total }}</p>
      </div>
      <div class="stat-card pending">
        <p class="label">En attente</p>
        <p class="value">{{ stats.en_attente }}</p>
      </div>
      <div class="stat-card accepted">
        <p class="label">Acceptées</p>
        <p class="value">{{ stats.acceptees }}</p>
      </div>
      <div class="stat-card refused">
        <p class="label">Refusées</p>
        <p class="value">{{ stats.refusees }}</p>
      </div>
    </div>

    <!-- Graphique -->
    <div class="graph-section">
      <h3>Répartition des demandes</h3>
      <PieChart
        :enAttente="stats.en_attente"
        :acceptees="stats.acceptees"
        :refusees="stats.refusees"
      />
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios'
import PieChart from '@/components/PieChart.vue'

const stats = ref({
  total: 0,
  en_attente: 0,
  acceptees: 0,
  refusees: 0,
})

const fetchDashboard = async () => {
  try {
    const res = await axios.get('/api/stats')
    stats.value = res.data
  } catch (error) {
    console.error('Erreur chargement stats :', error)
  }
  //test
  stats.value = {
    total: 10,
    en_attente: 4,
    acceptees: 3,
    refusees: 3,
  } // Supprimer cette ligne après les tests
}

onMounted(fetchDashboard)
</script>

<style scoped>
.dashboard {
  padding: 20px;
}

.stats-container {
  display: flex;
  gap: 20px;
  margin-bottom: 40px;
}

.stat-card {
  flex: 1;
  padding: 20px;
  border-radius: 10px;
  text-align: center;
  color: white;
  font-weight: bold;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.total {
  background-color: #2c3e50;
}
.pending {
  background-color: #e67e22;
}
.accepted {
  background-color: #27ae60;
}
.refused {
  background-color: #c0392b;
}

.graph-section {
  background: #fff;
  padding: 25px;
  border-radius: 10px;
  max-width: 600px;
  margin: auto;
}
</style>
