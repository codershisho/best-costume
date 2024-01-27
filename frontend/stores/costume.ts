import { ref } from "vue";
import { defineStore } from "pinia";
import { Menu } from "~/types/menu";
import { Product, ProductRegist } from "~/types/product";
// import { searchMenus } from "~/composables/menuApi";
import { fetchProducts, deleteProducts } from "~/composables/productApi";

export const useCostumeStore = defineStore("costume", () => {
  const menus = ref<Menu[] | null>();
  const selectedMenuId = ref(0);
  const products = ref<Product[] | null>();
  const editProduct = ref<ProductRegist | null>();

  const searchMenu = async () => {
    const { data } = await searchMenus();
    menus.value = data.value.data;
  };

  const setMenuId = (id: number) => {
    selectedMenuId.value = id;
  };

  const searchProductsById = async () => {
    const data = await fetchProducts("", 0, selectedMenuId.value);
    products.value = data.data;
  };

  return {
    menus,
    selectedMenuId,
    products,
    editProduct,
    searchMenu,
    setMenuId,
    searchProductsById,
  };
});
