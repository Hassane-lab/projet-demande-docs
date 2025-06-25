<template>
  <div class="auth-container">
    <h2>Connexion</h2>
    <form @submit.prevent="login">
      <input v-model="auth.email" type="email" placeholder="Email" required />
      <input v-model="auth.password" type="password" placeholder="Mot de passe" required />
      <button type="submit">Se connecter</button>
    </form>
    <p v-if="error" class="error">{{ error }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const router = useRouter()
const error = ref('')

const login = async () => {
  try {
    await auth.login({
      email: auth.email,
      password: auth.password,
    })

    if (auth.role === 'agent') {
      router.push('/dashboard')
    } else {
      router.push('/mes-demandes')
    }
  } catch (err) {
    console.error('Erreur de connexion:', err)
    error.value = 'Identifiants invalides'
  }
}
</script>

<style scoped>
.auth-container {
  max-width: 400px;
  margin: 60px auto;
  padding: 30px;
  background: #f9f9f9;
  border-radius: 12px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
  text-align: center;
}
input {
  display: block;
  width: 100%;
  margin: 10px 0;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
}
button {
  background: #007bff;
  color: white;
  border: none;
  padding: 12px;
  width: 100%;
  border-radius: 6px;
  font-weight: bold;
}
button:hover {
  background: #0056b3;
}
.error {
  color: red;
  margin-top: 10px;
}
</style>
