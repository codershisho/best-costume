<template>
  <div class="d-flex tw-justify-between tw-mb-4">
    <h2 class="tw-font-bold tw-text-xl tw-pt-2">衣装リスト</h2>
    <NuxtLink to="/admin/costume">
      <v-btn color="primary"> 衣装登録 </v-btn>
    </NuxtLink>
  </div>
  <div class="mt-2">
    <v-sheet class="mb-3 pl-3 rounded-lg">
      <div class="d-flex tw-items-center">
        <base-text
          class="ma-1"
          placeholder="search"
          clearable
          v-model="searchText"
          @click:clear="searchProducts"
          @update:modelValue="searchProducts"
        ></base-text>
        <v-btn
          class="tw-mx-3"
          variant="plain"
          density="compact"
          icon="mdi-swap-vertical"
        ></v-btn>
      </div>
    </v-sheet>
    <v-table class="tw-px-2 rounded-lg">
      <thead>
        <tr>
          <th class="!tw-w-2 !tw-px-2"><input type="checkbox" /></th>
          <th>衣装ID</th>
          <th>衣装名</th>
          <th>カテゴリー</th>
          <th>サムネイル</th>
          <th>登録日</th>
          <th>販売元</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(product, i) in products" :key="i">
          <td class="!tw-w-2 !tw-px-2"><input type="checkbox" /></td>
          <td>{{ product.id }}</td>
          <td>{{ product.name }}</td>
          <td>{{ product.menu }}</td>
          <td>
            <v-img aspect-ratio="1" contain :src="product.thumbnail"></v-img>
          </td>
          <td>{{ product.updated_at }}</td>
          <td v-if="product.scrape_site_id == 0">
            <v-chip>自社</v-chip>
          </td>
          <td v-else>
            <v-chip color="warning">{{ product.site.name }}</v-chip>
          </td>
        </tr>
      </tbody>
    </v-table>
    <div>
      <v-pagination
        class="oddo_pagination tw-mt-2"
        v-model="page"
        :length="pageLength"
        density="compact"
        @update:modelValue="searchProducts"
      ></v-pagination>
    </div>
  </div>
</template>

<script setup lang="ts">
import { fetchProducts } from "~/composables/productApi";
import { Product } from "~/types/product";

definePageMeta({
  layout: "admin",
});

const products = ref<Product[]>();
const page = ref(1);
const pageLength = ref(1);
const searchText = ref("");

searchProducts();

async function searchProducts() {
  const data = await fetchProducts(searchText.value);
  products.value = data.data;
  pageLength.value = data.meta.last_page;
}
</script>
