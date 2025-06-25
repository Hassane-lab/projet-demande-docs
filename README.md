
# 📝 Gestion des demandes de documents administratifs

Ce projet est un mini-système complet de gestion des demandes de documents administratifs.  
Il a été développé avec :
- **Laravel** pour le backend (API REST) : `sujet4fixe`
- **Vue.js (Vite)** pour le frontend : `frontfixed`

---

## ✅ Fonctionnalités principales

### 🎓 Côté étudiant (`user`)
- Inscription et connexion sécurisées
- Soumission de demandes via un formulaire
- Suivi de ses propres demandes (statut, commentaire)
- Réception de notifications lors des mises à jour

### 👨‍💼 Côté agent (`agent`)
- Connexion en tant qu’agent de scolarité
- Consultation de toutes les demandes
- Traitement des demandes : changement de statut, ajout de commentaire
- Tableau de bord avec statistiques (nombre total, en attente, acceptées, refusées)
- Système de notifications avec badge dynamique

---

## 🛠️ Technologies utilisées

| Backend        | Frontend       |
| -------------- | -------------- |
| Laravel 10     | Vue 3 (Vite)   |
| Laravel Sanctum| Vue Router     |
| MySQL          | Pinia          |
| Eloquent ORM   | Axios          |
| API REST       | Chart.js       |

---

## 🚀 Installation

### 🔹 Backend : Laravel (sujet4fixe)

```bash
git clone <lien-github>
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

### 🔹 Frontend : Vue.js (frontfixed)

```bash
cd frontend
npm install
npm run dev
```

---

# 🔑 Comptes de test

| Rôle     | Email                  | Mot de passe |
|----------|------------------------|--------------|
| Étudiant | hassane@example.com     | 12345678     |
| Agent    | admin@example.com       | 12345678     |

---

# 📌 API principales

- POST `/api/login` → Connexion
- POST `/api/register` → Inscription
- GET `/api/demandes` → Liste des demandes
- PUT `/api/demandes/{id}` → Mettre à jour une demande (agent)
- POST `/api/demandes` → Créer une demande (user)
- GET `/api/notifications` → Liste des notifications
- PUT `/api/notifications/{id}/read` → Marquer comme lue
- GET `/api/stats` → Statistiques (agent)

---

# 📂 Structure des répertoires

```
/backend (sujet4fixe)     -> Projet Laravel API
  ├── app/
  ├── routes/api.php
  ├── database/migrations/
  └── ...

/frontend (frontfixed)    -> Projet Vue.js
  └── src/
      ├── views/
      ├── components/
      ├── router/
      └── stores/
```

---

# 📹 Démo vidéo

👉 Lien vidéo de démonstration :https://drive.google.com/file/d/1vhtkHJG2B2q63138xecet8r8C8lywKnp/view?usp=drivesdk

------

# 👨‍💻 Réalisé par

Hassane Salam Dia  
Licence 3 Génie Logiciel – SUPDECO Dakar  
2025  
