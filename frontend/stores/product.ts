import { defineStore } from "pinia";
import { useApiFetch } from "~/composables/useApiFetch";
import { Product } from "~/types/product";

export const useProductStore = defineStore("product", {
  state: () => ({
    _product: {
      selected: 0,
      pages: 0,
      pageLength: 0,
      customerId: 0,
      products: [],
      productName: "", // グローバルな商品名検索
      isLikeSearch: false, // グローバスなお気に入り検索
    },
  }),

  getters: {
    product: (state) => state._product,
    selected: (state) => state._product.selected,
    pages: (state) => state._product.pages,
    pageLength: (state) => state._product.pageLength,
    customerId: (state) => state._product.customerId,
  },

  actions: {
    setCategory(v: number) {
      this._product.selected = v;
    },
    setPage(v: number) {
      this._product.pages = v;
    },
    setCustomerId(v: number) {
      this._product.customerId = v;
    },
    setProductName(v: string) {
      this._product.productName = v;
      this.searchProducts();
    },
    setIsLikeSearch() {
      this._product.isLikeSearch = !this._product.isLikeSearch;
      this.searchProducts();
    },
    /**
     * 商品一覧検索
     */
    async searchProducts() {
      const params = {
        customer_id: this._product.customerId,
        page: this._product.pages,
        category: this._product.selected,
        isLikeSearch: this._product.isLikeSearch,
      };
      // グローバルな商品検索の場合は、カテゴリーを除外する
      if (this._product.productName != "") {
        params.searchText = this._product.productName;
        delete params.category;
      }
      if (this._product.isLikeSearch) {
        delete params.category;
      }
      const { data } = await useApiFetch("/api/bc/master/products/search", {
        method: "get",
        params: params,
      });
      this._product.products = data.value.data;
      this._product.pageLength = data.value.meta.last_page;
    },

    /**
     * お気に入りの更新
     * @param costume
     */
    async favorite(costume: Product) {
      await useApiFetch(
        `/api/bc/customer/${this._product.customerId}/favorites`,
        {
          method: "post",
          body: costume,
        }
      );
      // 微妙だけど、いったん再検索
      this.searchProducts();
    },

    /**
     * 商品注文登録
     * @param productId
     */
    async order(productId: number) {
      return useApiFetch(
        `/api/bc/customer/${this._product.customerId}/orders`,
        {
          method: "post",
          body: {
            product_id: productId,
          },
        }
      );
    },
  },

  persist: {
    storage: persistedState.localStorage,
  },
});
