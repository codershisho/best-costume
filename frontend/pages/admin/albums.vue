<template>
  <v-sheet class="d-flex align-center pa-5 rounded-lg">
    <div class="tw-w-2/6">
      <input
        type="file"
        multiple
        accept=".jpg, .jpeg, .png"
        @change="handleFileChange"
      />
    </div>
    <div class="tw-w-1/6">
      <v-select
        v-model="selectedCategory"
        :items="categories"
        label="カテゴリーを選択"
        item-title="name"
        item-value="id"
        variant="solo-filled"
        flat
        density="compact"
        hide-details="auto"
      ></v-select>
    </div>
    <div class="tw-w-1/6 ml-3 mr-auto">
      <BaseButton
        text="アップロード"
        color="primary"
        @click="uploadFiles"
      ></BaseButton>
    </div>
  </v-sheet>
  <div class="pt-5">
    <div class="d-flex">
      <v-chip-group
        class="tw-w-4/6"
        color="#E65100"
        variant="tonal"
        v-model="filterCategory"
        @update:modelValue="searchAlbums"
      >
        <v-chip
          v-for="(category, i) in categories"
          :key="i"
          label
          class="tw-w-1/12"
          :value="category.id"
        >
          <div>
            {{ category.name }}
          </div>
        </v-chip>
      </v-chip-group>
    </div>
    <v-table class="pa-5 rounded-lg">
      <thead>
        <tr>
          <th>カテゴリー</th>
          <th>イメージ</th>
          <th>追加日</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(albumn, i) in albumns" :key="i">
          <td>
            <v-chip :color="albumn.category_color" label>
              {{ albumn.category_name }}
            </v-chip>
          </td>
          <td>
            <img width="100" :src="albumn.image_url" alt="Uploaded Image" />
          </td>
          <td>{{ albumn.created_at }}</td>
        </tr>
      </tbody>
    </v-table>
    <div class="text-center">
      <v-pagination
        v-model="page"
        :length="pageLength"
        @update:modelValue="searchCustomers"
      ></v-pagination>
    </div>
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
const filterCategory = ref(null);
const albumns = ref([]);
const page = ref(1);
const pageLength = ref(1);

searchCategories();
searchAlbums();

const handleFileChange = (event: Event) => {
  const input = event.target as HTMLInputElement;
  if (input.files) {
    filesToUpload.value = Array.from(input.files);
  }
};

async function searchAlbums() {
  const params = {};
  if (filterCategory != null) {
    params.category_id = filterCategory.value;
  }
  const { data } = await useApiFetch(
    `/api/bc/admin/albums/uploaded?page=${page.value}`,
    {
      method: 'get',
      params: params,
    }
  );
  albumns.value = data.value.data;
  pageLength.value = data.value.meta.last_page;
}

async function filter() {}

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
