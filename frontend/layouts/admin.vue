<template>
  <v-app>
    <div class="tw-flex tw-h-full">
      <div class="tw-px-6 tw-pt-10">
        <!-- <v-list>
        <v-list-item
          v-for="[icon, text, url] in links"
          :key="icon"
          :prepend-icon="icon"
          :title="text"
          :to="url"
          link
        ></v-list-item>
      </v-list> -->
        <v-list class="tw-flex tw-flex-col tw-items-center tw-gap-6">
          <div class="tw-w-40 tw-pb-10">
            <img src="/oddo_logo.png">
          </div>
          <v-list-item v-for="[icon, text, url] in links" :key="icon" :prepend-icon="icon" :title="text" :to="url" link
            bg-color="primary" class="menu-item !tw-rounded-lg tw-w-44"></v-list-item>
        </v-list>
      </div>
      <!-- <v-main class="bg-back !tw-pt-10">
      <v-container>
        <slot />
      </v-container>
    </v-main> -->
      <div class="tw-w-full tw-p-6 bg-back">
        <slot />
      </div>
    </div>
  </v-app>
</template>

<script setup lang="ts">
const drawer = ref(null);

const links = [
  ['mdi-home', 'ホーム', '/admin/home'],
  ['mdi-account-circle-outline', '顧客情報', '/admin/customers'],
  ['mdi-cart-outline', '注文管理', '/admin/orders'],
  ['mdi-hanger', '衣装管理', '/admin/costumes'],
  ['mdi-image-outline', 'アルバム', '/admin/albums'],
  ['mdi-cog-outline', '設定', '/admin/settings'],
];
</script>

<style>
.menu-item .v-list-item__overlay {
  background-color: royalblue;
}
</style>