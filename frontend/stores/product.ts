import { defineStore } from 'pinia';
import { useApiFetch } from '~/composables/useApiFetch';

export const useProductStore = defineStore('product', {
  state: () => ({
    _product: {
      selected: 0,
      pages: 0,
      pageLength: 0,
      products: []
    }
  }),

  getters: {
    product: (state) => state._product,
    selected: (state) => state._product.selected,
    pages: (state) => state._product.pages,
    pageLength: (state) => state._product.pageLength,
  },

  actions: {
    setCategory(v: number) {
      this._product.selected = v;
    },
    setPage(v: number) {
      this._product.pages = v;
    },
    clear() {
      this._product.selected = 0;
      this._product.pages = 0;
      this._product.pageLength = 0;
      this._product.products = [];
    },
    /**
     * 商品一覧検索
     */
    async searchProducts() {
      const { data } = await useApiFetch(
        `api/bc/master/products/search?page=${this._product.pages}&category=${this._product.selected}`
      );
      this._product.products = data.value.data;
      this._product.pageLength = data.value.meta.last_page;
    }
  },

  persist: {
    storage: persistedState.localStorage,
  }
});
