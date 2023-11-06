<template>
  <v-app>
    <v-navigation-drawer v-model="drawer" color="white" border>
      <v-list>
        <v-list-item
          v-for="[icon, text, url] in links"
          :key="icon"
          :prepend-icon="icon"
          :title="text"
          :to="url"
          link
        ></v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-main class="bg-back">
      <v-container>
        <slot />
      </v-container>
    </v-main>
  </v-app>
</template>

<script setup lang="ts">
const drawer = ref(null);

const links = [
  ['mdi-send', 'ホーム', '/admin/home'],
  ['mdi-send', '顧客情報', '/admin/customers'],
  ['mdi-send', '注文管理', '/admin/orders'],
  ['mdi-send', '衣装管理', '/admin/costumes'],
  ['mdi-send', 'アルバム', '/admin/albums'],
  ['mdi-send', 'セッティング', '/admin/settings'],
];
</script>
