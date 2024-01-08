<template>
  <v-sheet class="tw-w-2/6 rounded-lg mr-5 pa-5">
    <v-form v-model="valid">
      <BaseText
        class="pb-3"
        placeholder="商品名"
        :rules="[requiredValidation]"
        v-model="product.name"
      ></BaseText>
      <v-select
        class="py-3"
        :items="menus"
        placeholder="親メニュー"
        item-value="id"
        item-title="name"
        variant="solo-filled"
        flat
        density="compact"
        hide-details="auto"
        :rules="[requiredValidation]"
        v-model="parent"
        @update:model-value="selectedMenu = null"
      />
      <v-select
        class="py-3"
        :items="children"
        placeholder="子メニュー"
        item-value="id"
        item-title="name"
        variant="solo-filled"
        flat
        density="compact"
        :rules="[requiredValidation]"
        hide-details="auto"
        v-model="selectedMenu"
      />
      <BaseText
        class="py-3"
        placeholder="金額"
        v-model="product.price"
        type="number"
        :rules="[requiredValidation]"
      ></BaseText>
      <v-textarea
        class="py-3"
        rows="10"
        placeholder="商品説明"
        v-model="product.description"
        :rules="[requiredValidation]"
      ></v-textarea>
      <BaseButton
        class="mt-3"
        color="blue-accent-3"
        text="商品登録"
        :disabled="!valid"
        @click="onSave"
      ></BaseButton>
      <input
        type="file"
        multiple
        accept=".jpg, .jpeg, .png"
        @change="handleFileChange"
      />
    </v-form>
  </v-sheet>
</template>

<script setup lang="ts">
import { ProductRegist } from "../types/product";
import { Menu } from "../types/menu";

// 登録するモデル
const product = ref<ProductRegist>({
  id: 0,
  scrape_site_id: 0,
  name: null,
  category_id: 0,
  price: null,
  description: null,
  images: null,
});

// メニュー関連
const menus = ref<Menu[]>();
const parent = ref(null);
const selectedMenu = ref(null);

const children = computed(() => {
  if (parent.value == null) {
    return [];
  }
  return menus.value[parent.value - 1].children;
});

// バリデーション
const valid = ref(false);
const requiredValidation = (v: any) => !!v || "必ず入力してください";

setMenus();

/** メニュー検索 */
async function setMenus() {
  const { data } = await searchMenus();
  menus.value = data.value.data;
}
/** 衣装登録 */
async function onSave() {
  product.value.category_id = selectedMenu.value;
  const formData = new FormData();
  if (product.value.images != null) {
    product.value.images.forEach((file) => {
      formData.append("files[]", file);
    });
  }
  for (const key of Object.keys(product.value)) {
    formData.append(key, product.value[key]);
  }
  // console.log(formData);
  await registProduct(formData);
}
/** ファイル選択 */
const handleFileChange = (event: Event) => {
  const input = event.target as HTMLInputElement;
  if (input.files) {
    product.value.images = Array.from(input.files);
  }
};
</script>
