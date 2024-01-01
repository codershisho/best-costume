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
        @update:modelValue="searchAlbums"
      ></v-pagination>
    </div>
  </div>
</template>

<script setup lang="ts">
import { fetchCategory } from "~/composables/albumApi";
import { Category } from "~/types/Album";

definePageMeta({
  layout: "admin",
});

const { $showAlert } = useNuxtApp();
const filesToUpload = ref<File[]>([]);
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

/**
 * 一覧検索
 */
async function searchAlbums() {
  const { data } = await fetchAlbums(Number(filterCategory.value), page.value);
  albumns.value = data.value.data;
  pageLength.value = data.value.meta.last_page;
}

/**
 * カテゴリーマスタ検索
 */
async function searchCategories() {
  const { data } = await fetchCategory();
  categories.value = data.value;
}

/**
 * ファイルアップロード
 */
async function uploadFiles() {
  if (filesToUpload.value.length === 0) {
    $showAlert("warning", "", "アップロードするファイルが選択されていません");
    return;
  }

  if (selectedCategory.value == null) {
    $showAlert("warning", "", "カテゴリーが選択されていません");
    return;
  }

  const formData = new FormData();
  filesToUpload.value.forEach((file) => {
    formData.append("files[]", file);
  });
  formData.append("selectedCategory", selectedCategory.value);
  const response = await useApiFetch("/api/bc/admin/albums/upload", {
    method: "POST",
    body: formData,
  });

  if (response.status.value == "success") {
    $showAlert("success", "アップロード完了", response.data.value.message);
    searchAlbums();
  } else {
    $showAlert(
      "error",
      "アップロード失敗",
      "容量が制限を超えている可能性があります。"
    );
  }
  filesToUpload.value = [];
}
</script>
