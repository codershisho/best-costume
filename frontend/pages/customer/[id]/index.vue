<template>
  <div class="d-flex flex-wrap tw-gap-4">
    <v-card v-for="costume in costumes" class="!tw-rounded-lg" width="228">
      <NuxtLink :to="`/customer/${urlPathCustomerId}/item/${costume.id}`">
        <div>
          <div class="tw-p-4">
            <v-img aspect-ratio="1" contain :src="costume.thumbnail"></v-img>
            <v-btn
              @click="favorite(costume)"
              width="40px"
              height="40px"
              class="!tw-absolute tw-top-4 tw-left-4 heart-color"
              density="default"
              :icon="costume.favorite ? `mdi-heart` : `mdi-heart-outline`"
            ></v-btn>
          </div>
          <div class="tw-font-bold tw-p-5">{{ costume.name }}</div>
        </div>
      </NuxtLink>
    </v-card>
  </div>
  <v-pagination
    class="text-center"
    v-model="page"
    :length="pageLength"
    :total-visible="7"
    @update:modelValue="search"
  ></v-pagination>
</template>

<script setup lang="ts">
import { useProductStore } from "~/stores/product";
import { Product } from "~/types/product";

definePageMeta({
  middleware: "auth",
});

const productStore = useProductStore();
const urlPathCustomerId = useRoute().params.id;
productStore.setCustomerId(Number(urlPathCustomerId));
const costumes = ref<Product[]>();
const page = ref<number>(1);
const pageLength = ref<number>(1);

/** ストアの変更をwatchしてデータ更新 */
watch(
  () => productStore.product.products,
  () => {
    costumes.value = productStore.product.products;
    pageLength.value = productStore.product.pageLength;
  }
);

/** ページ検索 */
async function search() {
  productStore.setPage(page.value);
  productStore.searchProducts();
}

/** お気に入りボタン押下時 */
async function favorite(costume: Product) {
  productStore.favorite(costume);
}
</script>
