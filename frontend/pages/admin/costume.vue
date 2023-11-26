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
      <BaseText class="pb-3" placeholder="商品名" v-model="name"></BaseText>
      <BaseText class="py-3" placeholder="カテゴリー" v-model="name"></BaseText>
      <BaseText class="py-3" placeholder="金額" v-model="name"></BaseText>
      <BaseText class="py-3" placeholder="商品説明" v-model="name"></BaseText>
      <BaseButton
        class="mt-3"
        color="blue-accent-3"
        text="商品登録"
        @click="onSave"
      ></BaseButton>
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

const name = ref('');

searchSites();

/** プルダウンに表示するサイトリスト検索 */
async function searchSites() {
  const { data } = await useApiFetch('api/bc/admin/scrape/sites');
  sites.value = data.value;
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
async function onSave() {}
</script>
