<template>
  <div class="d-flex justify-center align-center tw-h-screen">
    <div>
      <div class="text-center tw-text-3xl tw-font-bold">STUDIO ODDO</div>
      <div class="text-center tw-text-2xl tw-text-gray-500">
        Customer Costume Selection Application
      </div>
      <div class="tw-mt-10 tw-text-xl">User Name</div>
      <base-text></base-text>
      <div class="tw-text-xl">Password</div>
      <base-text></base-text>
      <base-button
        class="w-100 !tw-h-12"
        color="blue-accent-3"
        text="Sign in"
        @click="authStore.login"
      ></base-button>
      <base-button
        class="w-100 !tw-h-12"
        color="blue-accent-3"
        text="test"
        @click="test"
      ></base-button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useAuthStore } from '../stores/auth';

definePageMeta({
  layout: 'login',
});

const authStore = useAuthStore();

async function test() {
  const res = await useApiFetch('/api/user');
}
</script>
