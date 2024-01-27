<template>
  <div v-for="(parent, i) in menus" :key="i" class="bg-white rounded">
    <div class="px-4 py-1 menu">
      <div class="menu-parent">{{ parent.name }}</div>
      <div
        v-for="(child, j) in parent.children"
        :key="j"
        class="menu-child rounded"
        :class="selectedMenu == child.id ? `menu-selected` : ``"
        @click="onClick(child)"
      >
        {{ child.name }}
      </div>
    </div>
    <div class="menu-border"></div>
  </div>
</template>

<script setup lang="ts">
import { useCostumeStore } from "~/stores/costume";

const store = useCostumeStore();
const { menus } = storeToRefs(store);
const selectedMenu = ref(0);

const onClick = (child: any) => {
  selectedMenu.value = child.id;
  store.setMenuId(child.id);
  store.searchProductsById();
};
</script>

<style scoped>
.menu {
  cursor: pointer;
}
.menu-parent {
  font-size: 1.25rem;
  color: grey;
  border-bottom: 1px solid rgb(224, 224, 224);
}
.menu-child {
  font-size: 0.95rem;
  padding: 6px;
  color: grey;
}
.menu-child:hover {
  background-color: rgb(20, 0, 131);
  color: white;
}
.menu-selected {
  background-color: rgb(210, 205, 255);
  color: rgb(20, 0, 131);
}
.menu-border {
  /* border-bottom: 2px rgb(212, 212, 212) solid; */
  padding: 1px 0 !important;
}
</style>
