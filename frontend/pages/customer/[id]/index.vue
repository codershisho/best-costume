<template>
  <div class="d-flex flex-wrap tw-gap-4">
    <v-card v-for="costume in costumes" class="!tw-rounded-lg" width="228">
      <div>
        <div class="tw-p-4">
          <v-img aspect-ratio="1" contain :src="costume.thumbnail"></v-img>
          <v-btn @click="addFavorite" width="40px" height="40px" class="!tw-absolute tw-top-4 tw-left-4 heart-color"
            density="default" icon="mdi-heart-outline"></v-btn>
        </div>
        <NuxtLink :to="`/customer/${urlPathCustomerId}/item/${costume.id}`">
          <div class="tw-font-bold tw-p-5">{{ costume.name }}</div>
        </NuxtLink>
      </div>
    </v-card>
  </div>
  <v-pagination class="text-center" v-model="page" :length="pageLength" :total-visible="7"
    @update:modelValue="search"></v-pagination>
</template>

<script setup lang="ts">
import { Product } from '~/types/product';

definePageMeta({
  middleware: "auth"
});

const authStore = useAuthStore();

const favoriteIcon = ref("mdi-heart-outline");

const addFavorite = () => {
  favoriteIcon.value = "mdi-heart";
}

const urlPathCustomerId = useRoute().params.id
const costumes = ref<Product[]>();
const page = ref<number>(1);
const pageLength = ref<number>(1);

search();

/** 衣装の検索 */
async function search() {
  const { data } = await useApiFetch(
    `api/bc/master/products/search?page=${page.value}`
  );
  costumes.value = data.value.data;
  pageLength.value = data.value.meta.last_page;
}

</script>
