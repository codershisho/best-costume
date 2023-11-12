<template>
    <div>
      <h2 class="tw-font-bold tw-text-2xl tw-mb-4">My Favorite</h2>
      <div class="d-flex flex-wrap tw-gap-6">
        <v-card v-for="n in 6" width="240" height="240">
          <div class="d-flex pa-5">
            <v-btn density="comfortable" icon="mdi-heart"></v-btn>
            <v-img :width="300" aspect-ratio="16/9" cover
              src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"></v-img>
          </div>
          <div class="tw-font-bold px-5">商品名A</div>
        </v-card>
      </div>
    </div>
</template>

<script setup lang="ts">
definePageMeta({
  layout: 'section',
});

</script>
