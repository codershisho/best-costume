<template>
  <div>
    <h2 class="tw-font-bold tw-text-2xl tw-mb-4">Album</h2>
    <div class="d-flex tw-gap-6 tw-mb-6">
      <v-btn class="tw-w-32" color="primary">
        All
      </v-btn>
      <v-btn class="tw-w-32" color="white">
        Mens
      </v-btn>
      <v-btn class="tw-w-32" color="white">
        Womens
      </v-btn>
      <v-btn class="tw-w-32" color="white">
        Kids
      </v-btn>
      <v-btn class="tw-w-32" color="white">
        Others
      </v-btn>
    </div>
    <div class="d-flex flex-wrap tw-gap-6">
      <div v-for="n in 6" class="d-flex">
        <v-dialog>
    <template v-slot:activator="{ props }">
      <v-img v-bind="props" class="rounded-lg" :width="240" height="240" aspect-ratio="16/9" cover
        src="https://cdn.vuetifyjs.com/images/parallax/material.jpg">
      </v-img>
    </template>
    <template v-slot:default="{ isActive }">
      <v-card-actions class="tw-w-1/2 tw-m-auto">
        <v-img @click="isActive.value = false" class="rounded-lg" :width="240" aspect-ratio="1" cover
          src="https://cdn.vuetifyjs.com/images/parallax/material.jpg">
        </v-img>
      </v-card-actions>
    </template>
  </v-dialog>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  layout: 'section',
});
</script>
