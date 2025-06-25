<template>
  <div>
    <Doughnut :data="chartData" :options="chartOptions" />
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, DoughnutController } from 'chart.js'
import { Doughnut } from 'vue-chartjs'

ChartJS.register(Title, Tooltip, Legend, ArcElement, DoughnutController)

const props = defineProps({
  enAttente: Number,
  acceptees: Number,
  refusees: Number,
})

const chartData = computed(() => ({
  labels: ['En attente', 'Acceptées', 'Refusées'],
  datasets: [
    {
      data: [props.enAttente, props.acceptees, props.refusees],
      backgroundColor: ['#e67e22', '#27ae60', '#c0392b'],
      borderWidth: 1,
    },
  ],
}))

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'bottom',
      labels: {
        boxWidth: 15,
        padding: 20,
      },
    },
  },
  layout: {
    padding: 10,
  },
}
</script>

<style scoped>
.chart-wrapper {
  max-width: 400px;
  height: 400px;
  margin: auto;
}
</style>
