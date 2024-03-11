import { ref } from "vue";
import { defineStore } from "pinia";
import { Menu, MenuDetail } from "~/types/menu";
import { Product, ProductRegist } from "~/types/product";
// import { searchMenus } from "~/composables/menuApi";
import { fetchProducts, deleteProducts } from "~/composables/productApi";

export const useCostumeStore = defineStore("costume", () => {
  const menus = ref<Menu[] | null>();
  const selectedMenuId = ref(0);
  const products = ref<Product[] | null>();
  const editProduct = ref<ProductRegist | null>();
  const parentMenu = ref(0);
  const childMenus = ref<MenuDetail[] | null>();
  const childMenu = ref(0);
  const pageLength = ref(0);

  const searchMenu = async () => {
    const { data } = await searchMenus();
    menus.value = data.value.data;
  };

  const setMenuId = (id: number) => {
    selectedMenuId.value = id;
  };

  const searchProductsById = async (text: string = "", page: number = 0) => {
    const { data, status, error } = await fetchProducts(
      text,
      page,
      selectedMenuId.value
    );

    products.value = data.value.data;
    pageLength.value = data.value.meta.last_page;
  };

  const selectMenu = async () => {
    const id = editProduct.value.category_id;
    for (const parent of menus.value) {
      for (const child of parent.children) {
        if (child.id === id) {
          parentMenu.value = parent.id;
        }
      }
    }
  };

  const setChildMenus = async (id: number) => {
    const parent = menus.value.find((item) => item.id === id);
    childMenus.value = parent ? parent.children : [];
    childMenu.value = selectedMenuId.value;
  };

  return {
    menus,
    selectedMenuId,
    products,
    editProduct,
    parentMenu,
    childMenus,
    childMenu,
    searchMenu,
    setMenuId,
    searchProductsById,
    selectMenu,
    setChildMenus,
    pageLength,
  };
});
