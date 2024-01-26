<template>
  <div class="d-flex tw-justify-between tw-mb-4">
    <h2 class="tw-font-bold tw-text-xl tw-pt-2">衣装リスト</h2>
    <NuxtLink to="/admin/costume">
      <v-btn color="primary"> 衣装登録 </v-btn>
    </NuxtLink>
  </div>
  <div class="d-flex">
    <div class="tw-w-2/12 mr-5">
      <CostumeMenus />
    </div>
    <div class="tw-w-10/12">
      <v-sheet class="mb-3 px-4 py-2 rounded-lg">
        <div class="d-flex tw-items-center">
          <base-text
            class="ma-1"
            placeholder="search"
            clearable
            v-model="searchText"
          ></base-text>
          <v-btn
            class="tw-mx-3"
            variant="plain"
            density="compact"
            icon="mdi-swap-vertical"
          ></v-btn>
          <v-btn color="error" @click="del">削除</v-btn>
        </div>
      </v-sheet>
      <v-table class="tw-px-2 rounded">
        <thead>
          <tr>
            <th class="!tw-w-2 !tw-px-2">
              <input type="checkbox" v-model="selectAll" />
            </th>
            <th>衣装ID</th>
            <th>衣装名</th>
            <th>サムネイル</th>
            <th>登録日</th>
            <th>販売元</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(product, i) in store.products" :key="i">
            <td class="!tw-w-2 !tw-px-2">
              <input type="checkbox" v-model="product.checked" />
            </td>
            <td>{{ product.id }}</td>
            <td>{{ product.name }}</td>
            <td>
              <v-img aspect-ratio="1" contain :src="product.thumbnail"></v-img>
            </td>
            <td>{{ product.updated_at }}</td>
            <td v-if="product.scrape_site_id == 0">
              <v-chip>自社</v-chip>
            </td>
            <td v-else>
              <v-chip color="warning">{{ product.site.name }}</v-chip>
            </td>
          </tr>
        </tbody>
      </v-table>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useCostumeStore } from "~/stores/costume";

definePageMeta({
  layout: "admin",
});

const store = useCostumeStore();
const searchText = ref("");
const selectAll = ref<boolean | null>(false);

store.searchMenu();

/** チェックボックスの選択状態をwatch */
watch(selectAll, (newVal) => {
  store.products?.forEach((product: any) => (product.checked = newVal));
});
watch(
  () => "store.products.*.checked",
  (newVal) => {
    store.products?.forEach((product: any) => (product.checked = newVal));
    const allChecked = store.products?.every((product: any) => product.checked);
    const someChecked = store.products?.some((product: any) => product.checked);
    selectAll.value = allChecked ? true : someChecked ? null : false;
  }
);

/** 削除 */
async function del() {
  const ids = store.products
    ?.filter((item) => item.checked == true)
    .map((item) => item.id);

  if (ids?.length == 0) {
    alert("削除対象を1件以上選択してください。");
  }

  await deleteProducts(ids);
}
</script>
