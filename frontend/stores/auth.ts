import { defineStore } from 'pinia';
import { useApiFetch } from '~/composables/useApiFetch';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    _isAuth: false,
    _user: null,
  }),

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
          // TODO ホーム画面に遷移 or 呼び出しもとで遷移
        }
      }
    },

    // TODO logout処理追加

    authClear() {
      this._isAuth = false;
      this._user = null;
    },
  },

  persist: true,
});
