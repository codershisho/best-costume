<template>
  <div class="d-flex justify-center align-center tw-h-screen">
    <div>
      <div class="tw-w-60 tw-m-auto tw-mb-4">
        <img src="/public/oddo_logo.png" />
      </div>
      <div class="text-center tw-text-2xl tw-text-gray-500">
        Customer Costume Selection Application
      </div>
      <div class="tw-mb-4">
        <div class="tw-mt-10 tw-text-xl tw-mb-2">User Name</div>
        <base-text v-model="credentials.name"></base-text>
      </div>
      <div class="tw-mb-7">
        <div class="tw-text-xl tw-mb-2">Password</div>
        <base-text v-model="credentials.password"></base-text>
      </div>
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
  layout: "login",
});

type Credentials = {
  name?: String;
  password?: String;
};

const authStore = useAuthStore();

const credentials = ref<Credentials>({
  name: "admin",
  password: "hogehoge",
});

async function onLogin() {
  await authStore.login(credentials.value);
}
</script>
