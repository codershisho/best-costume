import { defineStore } from 'pinia';
import { useApiFetch } from '~/composables/useApiFetch';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    _isAuth: false,
    _user: null,
  }),

  getters: {
    isAuth: (state) => state._isAuth,
    user: (state) => state._user,
  },

  actions: {
    async login(credentials) {
      // if(this._isAuth) {
      // }
      await useApiFetch('/api/sanctum/csrf-cookie');
      const { data, status } = await useApiFetch('/api/auth/login', {
        method: 'post',
        body: {
          email: 'admin@example.com',
          password: 'hogehoge',
        },
      });

      if (status.value === 'success') {
        const { data, status } = await useApiFetch('/api/user');
        if (status.value === 'success') {
          this._isAuth = true;
          this._user = data.value;
          navigateTo('/');
        }
      }
    },

    async logout() {
      const { data, status } = await useApiFetch('/api/auth/logout', {
        method: 'post',
      });

      if (status.value === 'success') {
        this.authClear();
        navigateTo('/login');
      }
    },

    authClear() {
      this._isAuth = false;
      this._user = null;
    },
  },

  persist: true,
});
