<template>
  <div>
    <p class="tw-font-bold tw-text-2xl">Samplse</p>
    <v-btn color="primary">buttons</v-btn>
    <v-btn color="primary" text="logout" @click="authStore.logout"></v-btn>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  middleware: 'auth',
});

const authStore = useAuthStore();
</script>
