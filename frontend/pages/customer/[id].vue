<template>
  <div>顧客専用ページ</div>
</template>

<script setup lang="ts">
definePageMeta({
  middleware: 'auth',
});

const authStore = useAuthStore();
</script>
