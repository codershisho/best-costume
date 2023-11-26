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

searchSites();

async function searchSites() {
  const { data } = await useApiFetch('api/bc/admin/scrape/sites');
  sites.value = data.value;
}

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
    $showAlert('success', '成功', message);
    return;
  }

  if (res.status.value == 'error') {
    loading.value = false;
    const errMessage = res.error.value.data.message;
    $showAlert('error', 'スクレイピングに失敗', errMessage);
  }
}
</script>
