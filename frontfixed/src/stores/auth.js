import { defineStore } from "pinia";
import axios from "axios";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: null,
    token: localStorage.getItem("token") || "",
  }),

  actions: {
    async login(credentials) {
      try {
        const response = await axios.post(
          "http://127.0.0.1:8000/api/login",
          credentials
        );
        this.token = response.data.access_token;
        localStorage.setItem("token", this.token);

        const userRes = await axios.get("http://127.0.0.1:8000/api/me", {
          headers: { Authorization: `Bearer ${this.token}` },
        });
        this.setUser(userRes.data);
        localStorage.setItem("role", userRes.data.role);

        return userRes.data;
      } catch (error) {
        console.error("Erreur lors de la connexion", error);
        throw error;
      }
    },

    setUser(data) {
      this.user = data;
    },

    logout() {
      this.user = null;
      this.token = "";
      localStorage.removeItem("token");
      localStorage.removeItem("role");
      this.$reset();
    },
  },

  getters: {
    role: (state) => state.user?.role || localStorage.getItem("role") || "",
    isAuthenticated: (state) => !!state.token,
  },
});
