<template>
  <div class="d-flex justify-center align-center tw-h-screen">
    <div>
      <div class="text-center tw-text-3xl tw-font-bold">STUDIO ODDO</div>
      <div class="text-center tw-text-2xl tw-text-gray-500">
        Customer Costume Selection Application
      </div>
      <div class="tw-mt-10 tw-text-xl">User Name</div>
      <base-text v-model="credentials.name"></base-text>
      <div class="tw-text-xl">Password</div>
      <base-text v-model="credentials.password"></base-text>
      <base-button
        class="w-100 !tw-h-12"
        color="blue-accent-3"
        text="Sign in"
        @click="onLogin"
      ></base-button>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  layout: 'login',
});

type Credentials = {
  name?: String;
  password?: String;
};

const authStore = useAuthStore();

const credentials = ref<Credentials>({
  name: '',
  password: '',
});

async function onLogin() {
  await authStore.login(credentials.value);
}
</script>
