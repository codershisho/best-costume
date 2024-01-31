<template>
  <div>
    <v-chip>{{ detail.category_name }}</v-chip>
    <h2 class="tw-font-bold tw-text-2xl tw-my-4">{{ detail.name }}</h2>
    <div class="tw-flex tw-gap-12 tw-p-8">
      <div class="tw-w-1/2">
        <v-img
          class="rounded-lg tw-bg-white tw-shadow-sm"
          aspect-ratio="1"
          contain
          :src="detail.images[0]"
        ></v-img>
        <div class="tw-grid tw-grid-cols-4 tw-gap-3 tw-mt-4">
          <v-img
            v-for="(image, i) in detail.images"
            class="rounded-lg tw-col-span-1 tw-bg-white tw-shadow-sm"
            aspect-ratio="1"
            contain
            :src="image"
          ></v-img>
        </div>
      </div>
      <div class="tw-flex tw-w-1/2 tw-flex-col tw-justify-between">
        <p>{{ detail.description }}</p>
        <div class="tw-text-right">
          <p class="tw-font-bold tw-text-xl">{{ detail.price }}</p>
          <div class="tw-flex tw-justify-between tw-mt-4">
            <v-btn
              width="40px"
              height="40px"
              class="heart-color"
              density="default"
              icon="mdi-heart-outline"
            ></v-btn>
            <v-btn class="tw-w-32" color="primary" @click="order">
              注文する
            </v-btn>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useProductStore } from "~/stores/product";
import { ProductDetail } from "~/types/product";

definePageMeta({
  layout: "section",
});

const { $showAlert } = useNuxtApp();
const urlPathProductId = useRoute().params.product_id;
const productStore = useProductStore();
const detail = ref<ProductDetail>({
  id: 0,
  scrape_site_id: 0,
  name: "",
  category_id: 0,
  category_name: "",
  price: 0,
  description: "",
  images: [],
});

onMounted(() => {
  // ここにmounted時に実行したい処理を記述
  search();
});

/** 衣装の詳細検索 */
async function search() {
  const { data, status, error } = await useApiFetch(
    `/api/bc/master/products/${urlPathProductId}`
  );

  if (status.value == "success") {
    detail.value = data.value.data;
    return;
  }

  if (status.value == "error") {
    const errMessage = error.value.data.message;
    $showAlert("error", "失敗", errMessage);
  }
}

/**
 * 衣装の注文
 */
async function order() {
  await productStore.order(Number(urlPathProductId));
}
</script>
