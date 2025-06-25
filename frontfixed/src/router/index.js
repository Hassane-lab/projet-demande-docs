import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import LoginView from "../views/LoginView.vue";
import RegisterView from "../views/RegisterView.vue";
import DashboardView from "../views/DashboardView.vue";
import MesDemandes from "../views/MesDemandes.vue";
import ListeDemandes from "../views/ListesDemandes.vue";
import NotificationView from "../views/NotificationView.vue";
import DemandeForm from "../views/DemandeForm.vue";

const routes = [
  { path: "/", name: "Home", component: HomeView },
  { path: "/login", name: "Login", component: LoginView },
  { path: "/register", name: "Register", component: RegisterView },
  { path: "/dashboard", name: "Dashboard", component: DashboardView },
  { path: "/mes-demandes", name: "MesDemandes", component: MesDemandes },
  { path: "/liste-demandes", name: "ListeDemandes", component: ListeDemandes },
  {
    path: "/notifications",
    name: "NotificationView",
    component: NotificationView,
  },
  { path: "/nouvelle-demande", name: "DemandeForm", component: DemandeForm },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
