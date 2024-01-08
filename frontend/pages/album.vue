<template>
  <div>
    <h2 class="tw-font-bold tw-text-2xl tw-mb-4">Album</h2>
    <div class="d-flex tw-gap-6 tw-mb-6">
      <v-chip-group v-model="filterCategory" @update:modelValue="searchAlbums">
        <v-chip
          v-for="(category, i) in categories"
          :color="category.color"
          label
        >
          {{ category.name }}
        </v-chip>
      </v-chip-group>
      <!-- {{ categories }} -->
    </div>
    <div class="d-flex flex-wrap tw-gap-6">
      <div v-for="album in albums" class="d-flex">
        <v-dialog class="popup-img">
          <template v-slot:activator="{ props }">
            <v-img
              v-bind="props"
              class="rounded-lg"
              :width="240"
              height="240"
              aspect-ratio="16/9"
              cover
              :src="album.image_url"
            >
            </v-img>
          </template>
          <template v-slot:default="{ isActive }">
            <v-card-actions class="tw-w-full">
              <v-img
                @click="isActive.value = false"
                class="rounded-lg"
                :width="240"
                aspect-ratio="1"
                cover
                :src="album.image_url"
              >
              </v-img>
            </v-card-actions>
          </template>
        </v-dialog>
      </div>
    </div>
    <div class="text-center">
      <v-pagination
        v-model="page"
        :length="pageLength"
        @update:modelValue="searchAlbums"
      ></v-pagination>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Category, Album } from "~/types/Album";

definePageMeta({
  layout: "section",
});

const categories = ref<Category[]>();
const filterCategory = ref(null);
const albums = ref<Album[]>();
const page = ref(1);
const pageLength = ref(1);

getCategory();

/** カテゴリー検索 */
async function getCategory() {
  const { data } = await fetchCategory();
  categories.value = data.value;
}

/** 画像検索 */
async function searchAlbums() {
  const { data } = await fetchAlbums(Number(filterCategory.value), page.value);
  albums.value = data.value.data;
  pageLength.value = data.value.meta.last_page;
}
</script>

<style>
.popup-img > .v-overlay__content {
  width: 50%;
}
</style>
