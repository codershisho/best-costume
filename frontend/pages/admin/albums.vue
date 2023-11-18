<template>
  <div class="d-flex align-center">
    <input
      type="file"
      multiple
      accept=".jpg, .jpeg, .png"
      @change="handleFileChange"
    />
    <v-select
      v-model="selectedCategory"
      :items="categories"
      label="カテゴリーを選択"
      item-title="name"
      item-value="id"
      outlined
    ></v-select>
    <BaseButton
      text="アップロード"
      color="primary"
      @click="uploadFiles"
    ></BaseButton>
  </div>
  <div>
    <v-table class="pa-5 rounded-lg">
      <thead>
        <tr>
          <th>カテゴリー</th>
          <th>イメージ</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(albumn, i) in albumns" :key="i">
          <td>{{ albumn.category_name }}</td>
          <td><img :src="albumn.image_url" alt="Uploaded Image" /></td>
        </tr>
      </tbody>
    </v-table>
  </div>
</template>

<script setup lang="ts">
import { Category } from '~/types/Album';

definePageMeta({
  layout: 'admin',
});

const filesToUpload = ref<File[]>([]);
const { $swal } = useNuxtApp();
const categories = ref<Category[]>();
const selectedCategory = ref(null);
const albumns = ref([]);

searchCategories();
searchAlbums();

const handleFileChange = (event: Event) => {
  const input = event.target as HTMLInputElement;
  if (input.files) {
    filesToUpload.value = Array.from(input.files);
  }
};

async function searchAlbums() {
  const { data } = await useApiFetch('/api/bc/admin/albums/uploaded');
  albumns.value = data.value;
}

async function searchCategories() {
  const { data } = await useApiFetch('/api/bc/master/categories');
  categories.value = data.value;
}

async function uploadFiles() {
  if (filesToUpload.value.length === 0) {
    $swal.fire({
      title: '注意',
      text: 'アップロードするファイルが選択されていません',
      icon: 'warning',
      toast: true,
      position: 'top-end', //画面右上
      showConfirmButton: false,
      timer: 3000, //3秒経過後に閉じる
    });
    return;
  }

  if (selectedCategory.value == null) {
    $swal.fire({
      title: '注意',
      text: 'カテゴリーが選択されていません',
      icon: 'warning',
      toast: true,
      position: 'top-end', //画面右上
      showConfirmButton: false,
      timer: 3000, //3秒経過後に閉じる
    });
    return;
  }

  const formData = new FormData();
  filesToUpload.value.forEach((file) => {
    formData.append('files[]', file);
  });
  formData.append('selectedCategory', selectedCategory.value);
  const response = await useApiFetch('/api/bc/admin/albums/upload', {
    method: 'POST',
    body: formData,
  });

  if (response.status.value == 'success') {
    $swal.fire({
      title: 'アップロード完了',
      text: response.data.value.message,
      icon: 'success',
      toast: true,
      position: 'top-end', //画面右上
      showConfirmButton: false,
      timer: 1500,
    });
    searchAlbums();
  } else {
    $swal.fire({
      title: 'アップロード失敗',
      text: '容量が制限を超えている可能性があります。',
      icon: 'error',
      toast: true,
      position: 'top-end', //画面右上
      showConfirmButton: false,
      timer: 3000,
    });
  }
  filesToUpload.value = [];
}
</script>
