<template>
  <div>
    <Navbar v-if="auth.isAuthenticated" />
    <router-view />
  </div>
</template>

<script setup>
import Navbar from './components/Navbar.vue'
import { useAuthStore } from './stores/auth'

const auth = useAuthStore()
</script>

<style scoped>
/* Tu peux ajouter ton style global ici si besoin */
</style>