import { useAuthStore } from "./../stores/auth";
import type { UseFetchOptions } from "nuxt/app";

export function useApiFetch<T>(path: string, options: UseFetchOptions<T> = {}) {
  const config = useRuntimeConfig();
  const headers: Record<string, string> = {
    accept: "application/json",
  };

  const token = useCookie("XSRF-TOKEN");

  if (token.value) {
    headers["X-XSRF-TOKEN"] = token.value;
  }

  if (process.server) {
    Object.assign(headers, useRequestHeaders(["Referer", "Cookie"]));
  }

  const defaultOptions: UseFetchOptions<T> = {
    baseURL: config.public.apiUrl as string,
    credentials: "include",
    watch: false,
    headers: {
      ...headers,
      ...(options.headers || {}),
    },
    ...options,
  };
  const { $showAlert } = useNuxtApp();
  return useFetch(path, {
    ...defaultOptions,
    onResponse({ request, response, options }) {
      if (response._data && response._data.message) {
        // _dataがあり、かつmessageキーを持っている場合
        $showAlert("success", "成功", response._data.message);
      }
      return response._data;
    },
    onResponseError({ response }) {
      console.error(response.status);
      if ([401, 419].includes(response.status)) {
        const authStore = useAuthStore();
        authStore.authClear();
        alert("認証切れです。ログイン画面に遷移します。");
        // ログイン画面への遷移処理はあなたのナビゲーションライブラリによって置き換えてください
        navigateTo("/login");
      } else {
        if (response._data && response._data.message) {
          // _dataがあり、かつmessageキーを持っている場合
          $showAlert("error", "失敗", response._data.message);
        }
        return response._data;
      }
    },
  });
}
