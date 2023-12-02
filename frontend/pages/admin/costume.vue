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
      label="外部サイトの衣装が載っているURLを貼り付けてください"
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
          :rules="[requiredValidation]"
        ></BaseText>
        <BaseText
          class="py-3"
          placeholder="商品説明"
          v-model="product.description"
          :rules="[requiredValidation]"
        ></BaseText>
        <BaseButton
          class="mt-3"
          color="blue-accent-3"
          text="商品登録"
          :disabled="!valid"
          @click="onSave"
        ></BaseButton>
      </v-form>
    </v-sheet>
    <v-sheet class="tw-w-4/6 rounded-lg">
      <div class="ma-3 pa-5 !tw-bg-slate-100">
        <div>
          {{ stored.title }}
        </div>
        <div class="d-flex">
          <div class="w-50">※画像エリア</div>
          <div class="w-50">
            {{ stored.description }}
          </div>
        </div>
        <div class="mt-5 d-flex">
          <div class="w-50">※サブ画像エリア</div>
          <div class="w-50">
            {{ stored.price }}
          </div>
        </div>
      </div>
    </v-sheet>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  layout: 'admin',
});

const { $showAlert } = useNuxtApp();
const url = ref('');
const sites = ref([]);
const selectedSite = ref('');
const loading = ref(false);
const stored = ref(null);

const product = ref({});

const menus = ref([]);
const parent = ref(null);
const children = computed(() => {
  if (parent.value == null) {
    return [];
  }
  return menus.value[parent.value].children;
});
const selectedMenu = ref(null);

const valid = ref(false);
const requiredValidation = (v) => !!v || '必ず入力してください';

searchSites();

/** プルダウンに表示するサイトリスト検索 */
async function searchSites() {
  const { data } = await useApiFetch('api/bc/admin/scrape/sites');
  sites.value = data.value;
}

async function searchMenus() {
  const { data } = await useApiFetch('api/bc/master/menus');
  menus.value = data.value.data;
}

/** スクレイプ処理 */
async function scrape() {
  loading.value = true;
  const res = await useApiFetch('api/bc/admin/scrape', {
    method: 'post',
    body: {
      site_id: selectedSite.value,
      url: url.value,
    },
  });

  if (res.status.value == 'success') {
    searchMenus();
    loading.value = false;
    const message = res.data.value.message;
    stored.value = res.data.value.data;
    $showAlert('success', '成功', message);
    return;
  }

  if (res.status.value == 'error') {
    loading.value = false;
    const errMessage = res.error.value.data.message;
    $showAlert('error', 'スクレイピングに失敗', errMessage);
  }
}

/** 商品登録処理 */
async function onSave() {
  product.value.scrape_site_id = stored.value.id;
  product.value.category_id = selectedMenu.value;

  const { data, status, error } = await useApiFetch('api/bc/master/products', {
    method: 'post',
    body: product.value,
  });

  if (status.value == 'success') {
    $showAlert('success', '成功', data.value.message);
    return;
  }

  if (status.value == 'error') {
    const errMessage = error.value.data.message;
    $showAlert('error', '失敗', errMessage);
  }
}
</script>
