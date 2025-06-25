<script setup>
import { onMounted, ref, computed } from 'vue'
import { useAuthStore } from '@/stores/auth'
import axios from 'axios'

const auth = useAuthStore()
const notifications = ref([])

const fetchNotifications = async () => {
  try {
    const token = localStorage.getItem('token')
    const res = await axios.get('http://127.0.0.1:8000/api/notifications', {
      headers: { Authorization: `Bearer ${token}` },
    })
    notifications.value = res.data.notifications
  } catch (error) {
    console.error('Erreur chargement notifications', error)
  }
}

const markAsRead = async (id) => {
  try {
    const token = localStorage.getItem('token')
    await axios.put(
      `http://127.0.0.1:8000/api/notifications/${id}/read`,
      {},
      {
        headers: { Authorization: `Bearer ${token} ` },
      },
    )
    await fetchNotifications()
  } catch (error) {
    console.error('Erreur marquage notification comme lue', error)
  }
}

const formatDate = (datetime) => {
  const date = new Date(datetime)
  return date.toLocaleString()
}

const filteredNotifications = computed(() => {
  if (auth.role === 'agent') {
    return [...notifications.value].sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
  } else {
    return [...notifications.value]
      .filter((notif) => notif.user_id === auth.user?.id)
      .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
  }
})

onMounted(fetchNotifications)
</script>

<template>
  <div class="container">
    <h2>Notifications</h2>
    <div v-if="filteredNotifications.length === 0">Aucune notification pour le moment.</div>
    <ul v-else>
      <li
        v-for="notif in filteredNotifications"
        :key="notif.id"
        :class="['notification-item', { unread: !notif.is_read }]"
      >
        <div>
          <strong>{{ notif.message }}</strong>
          <small class="date">{{ formatDate(notif.created_at) }}</small>
        </div>
        <button
          v-if="auth.role === 'user' && !notif.is_read"
          class="mark-read-btn"
          @click="markAsRead(notif.id)"
        >
          Marquer comme lue
        </button>
      </li>
    </ul>
  </div>
</template>

<style scoped>
.container {
  max-width: 700px;
  margin: auto;
  padding: 20px;
}
.notification-item {
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 12px;
  margin-bottom: 12px;
  background-color: #f5f5f5;
  transition: background-color 0.3s ease;
}
.unread {
  background-color: #ffe2ba;
}
.mark-read-btn {
  background-color: #007bff;
  color: white;
  padding: 5px 10px;
  margin-top: 8px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.mark-read-btn:hover {
  background-color: #0056b3;
}
.date {
  color: #666;
  font-size: 12px;
  display: block;
  margin-top: 4px;
}
</style>
