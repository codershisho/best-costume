<template>
  <div class="tw-bg-white tw-mb-4 tw-rounded-lg">
    <v-tabs v-model="tab" class="tw-mb-6">
      <v-tab value="own">自前</v-tab>
      <v-tab value="scrape">外部サイト</v-tab>
    </v-tabs>
  </div>
  <v-window v-model="tab">
    <v-window-item value="own">
      <RegistOwnCostume></RegistOwnCostume>
    </v-window-item>

    <v-window-item value="scrape">
      <RegistScrapeCostume></RegistScrapeCostume>
    </v-window-item>
  </v-window>
</template>

<script setup lang="ts">
definePageMeta({
  layout: "admin",
});

const tab = ref(null);
</script>
