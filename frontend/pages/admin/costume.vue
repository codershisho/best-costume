<template>
  <v-tabs v-model="tab" bg-color="primary">
    <v-tab value="own">自前</v-tab>
    <v-tab value="scrape">外部サイト</v-tab>
  </v-tabs>
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
