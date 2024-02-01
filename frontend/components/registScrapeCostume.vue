<template>
  <v-sheet class="d-flex align-center pa-5 rounded-lg">
    <div class="w-25 mr-3">
      <v-select
        v-model="selectedSite"
        :items="sites"
        label="サイトを選択"
        item-title="name"
        item-value="id"
        variant="solo-filled"
        flat
        density="compact"
        hide-details="auto"
      ></v-select>
    </div>
    <base-text
      class="mr-3"
      label="衣装サイトの登録したい衣装のURLを貼り付けてください"
      clearable
      v-model="url"
    >
    </base-text>
    <base-button
      color="blue-accent-3"
      text="プレビュー"
      :loading="loading"
      @click="scrape"
    >
    </base-button>
  </v-sheet>
  <div v-if="stored" class="d-flex mt-5">
    <v-sheet class="tw-w-2/6 rounded-lg mr-5 pa-5">
      <v-form v-model="valid">
        <BaseText
          class="pb-3"
          placeholder="商品名"
          :rules="[requiredValidation]"
          v-model="stored.title"
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
          type="number"
          v-model="stored.price"
          :rules="[requiredValidation]"
        ></BaseText>
        <v-textarea
          class="py-3"
          rows="10"
          placeholder="商品説明"
          v-model="stored.description"
          :rules="[requiredValidation]"
        ></v-textarea>
        <BaseButton
          class="mt-3 tw-w-full"
          color="blue-accent-3"
          text="商品登録"
          :disabled="!valid"
          @click="onSave"
        ></BaseButton>
      </v-form>
    </v-sheet>
    <v-sheet class="tw-w-4/6 rounded-lg">
      <div class="ma-3 pa-5 !tw-bg-slate-100">
        <div class="tw-font-bold tw-text-xl tw-mb-4">
          {{ stored.title }}
        </div>
        <div class="d-flex tw-gap-4">
          <div class="tw-w-96">
            <div class="mb-2">
              <img :src="images[0]" />
            </div>
            <div class="d-flex tw-gap-2 tw-flex-wrap">
              <div class="tw-w-12" v-for="(image, i) in images" :key="i">
                <img :src="image" />
              </div>
            </div>
          </div>
          <div
            class="tw-flex tw-flex-col tw-w-full tw-justify-between tw-items-end"
          >
            <div>
              {{ stored.description }}
            </div>
            <div class="tw-font-bold tw-text-xl">¥{{ stored.price }}</div>
          </div>
        </div>
      </div>
    </v-sheet>
  </div>
</template>

<script setup lang="ts">
import { execScrape } from "~/composables/scrapeApi";
import { ProductRegist } from "../types/product";
import { Site, ScrapeResult } from "../types/scrape";

const url = ref("");
const sites = ref<Site[]>();
const selectedSite = ref("");
const loading = ref(false);
const stored = ref<ScrapeResult | null>();
const images = ref([]);
const product: ProductRegist = {
  id: 0,
  name: "",
  price: 0,
  description: "",
  scrape_site_id: 0,
  category_id: 0,
  images: null,
};
const menus = ref([]);
const parent = ref(null);
const selectedMenu = ref(null);
const valid = ref(false);

searchSites();
const children = computed(() => {
  if (parent.value == null) {
    return [];
  }
  return menus.value[parent.value - 1].children;
});

const requiredValidation = (v) => !!v || "必ず入力してください";

/** 変数初期化 */
const clearVar = () => {
  selectedSite.value = "";
  url.value = "";
  stored.value = null;
  images.value = [];
  parent.value = null;
  selectedMenu.value = null;
};

/** プルダウンに表示するサイトリスト検索 */
async function searchSites() {
  const { data } = await searchScrapeSite();
  sites.value = data.value as Site[];
}

async function setMenus() {
  const { data } = await searchMenus();
  menus.value = data.value.data;
}

/** スクレイプ処理 */
async function scrape() {
  loading.value = true;
  const res = await execScrape(Number(selectedSite.value), url.value);
  console.log(res);

  stored.value = res.data.value.data;
  images.value = stored.value.images.split(",");
  loading.value = false;
  setMenus();
}

/** 商品登録処理 */
async function onSave() {
  product.name = stored.value.title;
  product.price = Number(stored.value.price);
  product.description = stored.value.description;
  product.scrape_site_id = stored.value.id;
  product.category_id = selectedMenu.value;
  await registProduct(product);
  clearVar();
}
</script>
