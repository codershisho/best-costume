<template>
  <div class="d-flex tw-justify-between tw-mb-4">
    <h2 class="tw-font-bold tw-text-xl tw-pt-2">衣装リスト</h2>
    <NuxtLink to="/admin/costume">
      <v-btn color="primary"> 衣装登録 </v-btn>
    </NuxtLink>
  </div>
  <div class="d-flex parent">
    <div class="tw-w-2/12 mr-5 child">
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
            @update:focused="onSearchText"
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
      <v-table class="tw-px-2 rounded" height="77vh" fixed-header>
        <thead>
          <tr>
            <th class="!tw-w-2 !tw-px-2">
              <input type="checkbox" v-model="selectAll" />
            </th>
            <th class="!tw-w-1/12 !tw-text-sm">ID</th>
            <th class="!tw-w-5/12 !tw-text-sm">衣装名</th>
            <th class="!tw-w-3/12 !tw-text-sm">サムネイル</th>
            <th class="!tw-w-1/12 !tw-text-sm">価格</th>
            <th class="!tw-w-1/12 !tw-text-sm">登録日</th>
            <th class="!tw-w-1/12 !tw-text-sm">販売元</th>
            <th class="!tw-w-1/12 !tw-text-sm">編集</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(product, i) in store.products"
            :key="i"
            :draggable="true"
            @dragstart="dragStart(i)"
            @dragenter="dragEnter(i)"
            @dragover.prevent
            @dragend="dragEnd"
          >
            <td class="!tw-w-2 !tw-px-2">
              <input type="checkbox" v-model="product.checked" />
            </td>
            <td class="!tw-text-sm">{{ product.id }}</td>
            <td class="!tw-text-sm">{{ product.name }}</td>
            <td>
              <v-img aspect-ratio="1" contain :src="product.thumbnail"></v-img>
            </td>
            <td class="!tw-text-sm">{{ product.price }}</td>
            <td class="!tw-text-sm">{{ product.updated_at }}</td>
            <td v-if="product.scrape_site_id == 0">
              <v-chip>自社</v-chip>
            </td>
            <td v-else>
              <v-chip color="warning">{{ product.site.name }}</v-chip>
            </td>
            <td class="text-center">
              <v-btn flat icon="mdi-pencil" @click="clickRow(product)"></v-btn>
            </td>
          </tr>
        </tbody>
      </v-table>
    </div>
  </div>
  <DialogCostume v-model:open="isShowDialog" @close="close" />
  <v-pagination
    class="text-center"
    v-model="page"
    :length="store.pageLength"
    :total-visible="7"
    @update:modelValue="search"
  ></v-pagination>
</template>

<script setup lang="ts">
import { useCostumeStore } from "~/stores/costume";

definePageMeta({
  layout: "admin",
});

const store = useCostumeStore();
const selectAll = ref<boolean | null>(false);
const isShowDialog = ref(false);
const searchText = ref(""); // フィルタリング条件を保持する変数
const { $swal } = useNuxtApp();
const dragIndex = ref<number | null>(null);
const page = ref<number>(1);
const pageLength = ref<number>(1);

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

async function onSearchText() {
  await search();
  page.value = 1;
}
async function search() {
  store.searchProductsById(searchText, page.value);
}

/** 削除 */
async function del() {
  const ids = store.products
    ?.filter((item) => item.checked == true)
    .map((item) => item.id);

  if (ids?.length == 0) {
    alert("削除対象を1件以上選択してください。");
    return;
  }
  $swal
    .fire({
      title: "削除確認",
      text: "本当に削除してもいいですか？",
      icon: "info",
      showCancelButton: true,
    })
    .then((result) => {
      if (result.value) {
        deleteProducts(ids);
        search();
      }
    });
}

const clickRow = (product: Product) => {
  store.editProduct = product;
  store.selectMenu();
  isShowDialog.value = true;
};

/** ダイアログが閉じたら再検索 */
const close = () => {
  search();
};

const dragStart = (index: number) => {
  dragIndex.value = index;
};

const dragEnter = (index: number) => {
  if (index === dragIndex.value) return;
  const deleteElement = store.products.splice(dragIndex.value, 1)[0];
  store.products.splice(index, 0, deleteElement);
  dragIndex.value = index;
};

const dragEnd = () => {
  updateOrder();
  dragIndex.value = null;
};

const updateOrder = () => {
  useApiFetch(`/api/bc/master/products/update_order`, {
    method: "post",
    body: store.products,
  });
};
</script>

<style scoped>
/* メニューのスクロール対応（長すぎるためスクロールさせる） */
.parent {
  height: 89vh;
  overflow: hidden;
}
.child {
  height: 89vh;
  overflow-y: auto;
  /* 以下のプロパティでスクロールバーを非表示に */
  -ms-overflow-style: none;
  scrollbar-width: none;
}
.child::-webkit-scrollbar {
  display: none;
}
</style>
