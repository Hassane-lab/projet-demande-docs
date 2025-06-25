<template>
  <div class="home-container">
    <div class="welcome-box">
      <h1>Bienvenue sur la plateforme de gestion des demandes</h1>
      <p>Connectez-vous ou inscrivez-vous pour commencer à faire vos demandes.</p>
      <div class="buttons">
        <router-link to="/login" class="btn btn-login">Se connecter</router-link>
        <router-link to="/register" class="btn btn-register">S'inscrire</router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
defineOptions({
  name: 'HomeView'
})
</script>

<style scoped>
.home-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 85vh;
  background: linear-gradient(to right, #f8f9fa, #e9ecef); /* fond clair avec léger dégradé */
}

.welcome-box {
  background: white;
  padding: 40px;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  text-align: center;
  max-width: 600px;
  width: 90%;
}

.welcome-box h1 {
  color: #003366; /* bleu foncé élégant */
  margin-bottom: 20px;
}

.welcome-box p {
  color: #555;
  margin-bottom: 30px;
}

.buttons {
  display: flex;
  justify-content: center;
  gap: 20px;
}

.btn {
  padding: 10px 20px;
  border-radius: 4px;
  text-decoration: none;
  font-weight: bold;
  transition: background 0.3s ease;
}

.btn-login {
  background: #007bff;
  color: white;
}

.btn-login:hover {
  background: #0056b3;
}

.btn-register {
  background: #28a745;
  color: white;
}

.btn-register:hover {
  background: #1e7e34;
}
</style>