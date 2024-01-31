<template>
  <v-app class="bg-back">
    <header class="tw-flex tw-justify-between tw-p-8">
      <div class="tw-w-48">
        <img src="/public/oddo_logo.png" />
      </div>
      <div class="tw-flex tw-w-80 tw-gap-4">
        <v-text-field class="mr-2" bg-color="white" hide-details prepend-inner-icon="mdi-magnify" single-line
          density="compact" variant="solo" placeholder="衣装名を検索" v-model="productName"
          @update:model-value="updProductName">
        </v-text-field>

        <v-btn width="40px" height="40px" class="heart-color" density="default"
          :icon="productStore._product.isLikeSearch ? `mdi-heart` : `mdi-heart-outline`"
          @click="productStore.setIsLikeSearch"></v-btn>
      </div>
    </header>
    <div class="tw-flex tw-h-full tw-px-3">
      <div class="tw-flex tw-flex-col tw-w-80 tw-p-3 tw-mx-auto">
        <div class="tw-flex tw-flex-col tw-gap-4">
          <h2 class="tw-font-bold tw-text-xl">Category</h2>
          <v-expansion-panels v-for="(menu, i) in menus">
            <v-expansion-panel bg-color="primary">
              <v-expansion-panel-title class="tw-font-bold tw-text-md" expand-icon="mdi-plus" collapse-icon="mdi-minus">
                {{ menu.name }}
              </v-expansion-panel-title>
              <v-expansion-panel-text class="st_side-menu">
                <v-list class="tw-w-full !tw-p-0" bg-color="white">
                  <v-list-item v-for="(child, i) in menu.children" key="i" :value="child.id" :title="child.name"
                    @click="selectCategory(child.id)">
                  </v-list-item>
                </v-list>
              </v-expansion-panel-text>
            </v-expansion-panel>
          </v-expansion-panels>
        </div>
        <NuxtLink to="/album">
          <div class="tw-mt-6">
            <h2 class="tw-font-bold tw-text-xl tw-mb-4">Sample Album</h2>
            <div>
              <v-img class="tw-rounded-lg" aspect-ratio="1" cover
                src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"></v-img>
            </div>
          </div>
        </NuxtLink>
        <div class="tw-text-center tw-mt-auto">
          <v-btn text="サインアウト" variant="text" prepend-icon="mdi-logout" @click="authStore.logout" />
        </div>
      </div>
      <div class="tw-w-full tw-p-3">
        <slot />
      </div>
    </div>
  </v-app>
</template>

<script setup lang="ts">
import { useProductStore } from "~/stores/product";
import { Menu } from "../types/menu";

const menus = ref<Menu[]>([]);
const authStore = useAuthStore();
const productStore = useProductStore();
// グローバルな商品名検索の商品名格納
const productName = ref("");
productStore.clear();
searchMenus();

/** メニューの検索 */
async function searchMenus() {
  const { data } = await useApiFetch("/api/bc/master/menus");
  menus.value = data.value.data;
}

/**
 * メニューに応じた商品検索
 * @param id
 */
function selectCategory(id: number) {
  productStore.setCategory(id);
  productStore.searchProducts();
}

/** 検索対象の商品名を更新 */
function updProductName(productName: string) {
  productStore.setProductName(productName);
}
</script>

<style>
.v-navigation-drawer__content::-webkit-scrollbar {
  display: none;
}

.st_side-menu>.v-expansion-panel-text__wrapper {
  padding: 0;
}

.heart-color {
  color: #ff4c24;
}

.v-list-item-title {
  font-size: 0.75rem;
}
</style>
