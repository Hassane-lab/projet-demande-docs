<script setup>
defineOptions({ name: 'AppNavbar' })
import { useAuthStore } from '../stores/auth'
import { computed, ref } from 'vue'
import { useRouter } from 'vue-router'

const auth = useAuthStore()
const router = useRouter()
const role = computed(() => auth.role)
const isAuthenticated = computed(() => auth.isAuthenticated)

const menuOpen = ref(false)

function handleLogout() {
  auth.logout()
  router.push('/login')
}

function toggleMenu() {
  menuOpen.value = !menuOpen.value
}
</script>

<template>
  <nav class="navbar">
    <div class="nav-container">
      <button class="burger" @click="toggleMenu">☰</button>
      <ul :class="['nav-list', { open: menuOpen }]">
        <li><router-link to="/">Accueil</router-link></li>

        <li v-if="isAuthenticated && role === 'agent'">
          <router-link to="/dashboard">Dashboard</router-link>
        </li>
        <li v-if="isAuthenticated && role === 'agent'">
          <router-link to="/liste-demandes">Demandes</router-link>
        </li>

        <li v-if="isAuthenticated && role === 'user'">
          <router-link to="/mes-demandes">Mes demandes</router-link>
        </li>
        <li v-if="isAuthenticated && role === 'user'">
          <router-link to="/nouvelle-demande">Nouvelle demande</router-link>
        </li>

        <li v-if="isAuthenticated">
          <router-link to="/notifications">Notifications</router-link>
        </li>

        <li v-if="isAuthenticated">
          <a href="#" @click.prevent="handleLogout">Déconnexion</a>
        </li>
      </ul>
    </div>
  </nav>
</template>

<style scoped>
.navbar {
  background-color: #003366;
  padding: 12px 0;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.nav-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.burger {
  display: none;
  font-size: 1.8em;
  color: #fff;
  background: none;
  border: none;
  cursor: pointer;
}

.nav-list {
  display: flex;
  justify-content: center;
  list-style: none;
  gap: 25px;
  margin: 0;
  padding: 0;
}

.nav-list li a {
  color: #fff;
  text-decoration: none;
  font-weight: 500;
  position: relative;
  padding: 5px 10px;
  transition: color 0.3s;
}

.nav-list li a:hover {
  color: #66ccff;
}

.nav-list li a::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: -2px;
  width: 0;
  height: 2px;
  background-color: #66ccff;
  transition: width 0.3s;
}

.nav-list li a:hover::after {
  width: 100%;
}

/* Responsive */
@media (max-width: 768px) {
  .burger {
    display: block;
  }

  .nav-list {
    flex-direction: column;
    background-color: #003366;
    width: 100%;
    display: none;
    margin-top: 10px;
    gap: 10px;
  }

  .nav-list.open {
    display: flex;
  }
}
</style>