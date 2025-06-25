<template>
  <div class="auth-container">
    <h2>Inscription</h2>
    <form @submit.prevent="register">
      <input v-model="email" type="email" placeholder="Email" required />
      <input v-model="password" type="password" placeholder="Mot de passe" required />
      <button type="submit">S'inscrire</button>
    </form>
    <p v-if="error" class="error">{{ error }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const error = ref('')
const router = useRouter()

const register = async () => {
  try {
    await axios.post('http://127.0.0.1:8000/api/register', {
      email: email.value,
      password: password.value,
    })
    router.push('/login')
  } catch (err) {
    console.error('Erreur d’inscription:', err)
    error.value = "Erreur lors de l'inscription"
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
  background: #28a745;
  color: white;
  border: none;
  padding: 12px;
  width: 100%;
  border-radius: 6px;
  font-weight: bold;
}
button:hover {
  background: #1e7e34;
}
.error {
  color: red;
  margin-top: 10px;
}
</style>
