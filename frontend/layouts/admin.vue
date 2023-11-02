<template>
  <v-app>
    <v-navigation-drawer v-model="drawer" color="back" border>
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
  ['mdi-send', '顧客管理', '/customers'],
  ['mdi-send', '注文一覧', '/orders'],
];
</script>
