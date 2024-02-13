import { defineStore } from "pinia";
import { useApiFetch } from "~/composables/useApiFetch";

type Credentials = {
  name?: String;
  password?: String;
};

export const useAuthStore = defineStore("auth", {
  state: () => ({
    _isAuth: false,
    _user: null,
  }),

  getters: {
    isAuth: (state) => state._isAuth,
    user: (state) => state._user,
  },

  actions: {
    async login(credentials?: Credentials) {
      await useApiFetch("/api/sanctum/csrf-cookie");
      const { data, status } = await useApiFetch("/api/auth/login", {
        method: "post",
        body: credentials,
      });

      if (status.value === "success") {
        const { data, status } = await useApiFetch("/api/user");
        if (status.value === "success") {
          this._isAuth = true;
          this._user = data.value;
          const customer_id = this._user.customer_id;
          if (customer_id == 0) {
            navigateTo("/admin/customers");
          } else {
            navigateTo(`/customer/${customer_id}`);
          }
        }
      }
    },

    async logout() {
      const { data, status } = await useApiFetch("/api/auth/logout", {
        method: "post",
      });

      if (status.value === "success") {
        this.authClear();
        navigateTo("/login");
      }
    },

    authClear() {
      this._isAuth = false;
      this._user = null;
    },
  },

  persist: {
    storage: persistedState.localStorage,
  },
});
