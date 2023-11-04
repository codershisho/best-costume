<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" color="back" border>
      <div class="d-flex justify-center">
        <div class="tw-w-10/12">
          <v-btn class="mt-3 w-100" color="primary" @click="isOpenMens = !isOpenMens">
            MENS
          </v-btn>
          <v-list v-show="isOpenMens" elevation="0" class="mt-1 w-100 rounded-lg" bg-color="white">
            <v-list-item v-for="(menuMen, i) in menusMens" key="i" :value="menuMen" :title="menuMen.name.toString()">
            </v-list-item>
          </v-list>
        </div>
      </div>
      <div class="d-flex justify-center">
        <div class="tw-w-10/12">
          <v-btn class="mt-3 w-100" color="primary" @click="isOpenWomens = !isOpenWomens">
            WOMENS
          </v-btn>
          <v-list v-show="isOpenWomens" elevation="0" class="mt-1 w-100 rounded-lg" bg-color="white">
            <v-list-item v-for="(menusWoman, i) in menusWomans" key="i" :value="menusWoman"
              :title="menusWoman.name.toString()">
            </v-list-item>
          </v-list>
        </div>
      </div>
      <div class="d-flex justify-center">
        <div class="tw-w-10/12">
          <v-btn class="mt-3 w-100" color="primary" @click="isOpenKids = !isOpenKids">
            KIDS
          </v-btn>
          <v-list v-show="isOpenKids" elevation="0" class="mt-1 w-100 rounded-lg" bg-color="white">
            <v-list-item v-for="(menusKid, i) in menusKids" key="i" :value="menusKid" :title="menusKid.name.toString()">
            </v-list-item>
          </v-list>
        </div>
      </div>
      <NuxtLink to="/album">
        <div>
          <div class="mt-3 tw-text-2xl tw-font-bold tw-text-center">
            Sample Album
          </div>
          <div>
            <v-sheet class="mx-5" height="100" color="grey"> </v-sheet>
          </div>
        </div>
      </NuxtLink>
      <div>
        <v-btn class="mt-3 w-100" text="サインアウト" variant="text" prepend-icon="mdi-logout" @click="authStore.logout" />
      </div>
    </v-navigation-drawer>

    <v-app-bar flat color="back">
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
      <v-app-bar-title>Applications</v-app-bar-title>
      <v-spacer></v-spacer>
      <v-text-field class="mr-2" bg-color="white" hide-details prepend-inner-icon="mdi-magnify" single-line
        density="compact" variant="solo" placeholder="衣装名を検索">
      </v-text-field>
      <NuxtLink to="/favorite">
        <v-btn class="bg-white" icon="mdi-heart-outline" variant="elevated"></v-btn>
      </NuxtLink>
    </v-app-bar>

    <v-main class="bg-back">
      <v-container>
        <slot />
      </v-container>
    </v-main>
  </v-app>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Menu } from '../types/menu';

const drawer = ref(true);

const menusMens = ref<Menu[]>([
  {
    id: 1,
    name: 'ドレス',
    url: '',
  },
  {
    id: 2,
    name: 'スーツ',
    url: '',
  },
  {
    id: 3,
    name: '七五三',
    url: '',
  },
  {
    id: 4,
    name: '振袖',
    url: '',
  },
  {
    id: 5,
    name: '着物',
    url: '',
  },
]);

const menusWomans = ref<Menu[]>([
  {
    id: 1,
    name: 'ドレス',
    url: '',
  },
  {
    id: 2,
    name: 'スーツ',
    url: '',
  },
  {
    id: 3,
    name: '七五三',
    url: '',
  },
  {
    id: 4,
    name: '振袖',
    url: '',
  },
  {
    id: 5,
    name: '着物',
    url: '',
  },
]);

const menusKids = ref<Menu[]>([
  {
    id: 1,
    name: 'ドレス',
    url: '',
  },
  {
    id: 2,
    name: 'スーツ',
    url: '',
  },
  {
    id: 3,
    name: '七五三',
    url: '',
  },
  {
    id: 4,
    name: '振袖',
    url: '',
  },
  {
    id: 5,
    name: '着物',
    url: '',
  },
]);

const isOpenMens = ref(false);
const isOpenWomens = ref(false);
const isOpenKids = ref(false);

const authStore = useAuthStore();
</script>

<style>
.v-navigation-drawer__content::-webkit-scrollbar {
  display: none;
}
</style>
