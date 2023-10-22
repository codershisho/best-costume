import { useAuthStore } from './../stores/auth';
import type { UseFetchOptions } from 'nuxt/app';

export function useApiFetch<T>(path: string, options: UseFetchOptions<T> = {}) {
  const config = useRuntimeConfig();
  let headers: any = {
    accept: 'application/json',
    'Content-type': 'application/json',
  };

  const token = useCookie('XSRF-TOKEN');

  if (token.value) {
    headers['X-XSRF-TOKEN'] = token.value as string;
  }

  if (process.server) {
    headers = {
      ...headers,
      ...useRequestHeaders(['Referer', 'Cookie']),
    };
  }

  return useFetch(path, {
    baseURL: config.public.apiBaseURL,
    credentials: 'include',
    watch: false,
    ...options,
    headers: {
      ...headers,
      ...options?.headers,
    },
    onResponse({ request, response, options }) {
      // Process the response data
      return response._data;
    },
    onResponseError({ request, response, options }) {
      // Handle the response errors
      console.error(response.status);
      if (response.status === 401) {
        const authStore = useAuthStore();
        authStore.authClear();
        alert('認証切れです。ログイン画面に遷移します。');
        // TODO ログイン画面へ遷移処理
      }
    },
  });
}
