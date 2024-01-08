<template>
  <v-sheet class="d-flex tw-justify-between tw-items-center pa-5 rounded-lg">
    <div class="tw-w-full tw-pr-12">
      <input
        type="file"
        multiple
        accept=".jpg, .jpeg, .png"
        @change="handleFileChange"
      />
    </div>
    <div class="tw-flex tw-items-center tw-gap-4">
      <div class="tw-w-full">
        <v-select
          v-model="selectedCategory"
          :items="categories"
          label="カテゴリー"
          item-title="name"
          item-value="id"
          variant="solo-filled"
          flat
          density="compact"
          hide-details="auto"
          class="tw-w-36"
        ></v-select>
      </div>
      <div class="tw-w-full">
        <BaseButton
          text="アップロード"
          color="primary"
          @click="uploadFiles"
          class="!tw-h-auto !tw-py-3 !tw-px-4"
        ></BaseButton>
      </div>
    </div>
  </v-sheet>
  <div class="pt-5">
    <div class="d-flex">
      <v-chip-group
        class="tw-w-4/6 tw-gap-2 tw-mb-4"
        color="#E65100"
        variant="tonal"
        v-model="filterCategory"
        @update:modelValue="searchAlbums"
      >
        <v-chip
          v-for="(category, i) in categories"
          :key="i"
          label
          class="tw-w-24 !tw-m-0 tw-items-center tw-justify-center !tw-h-auto !tw-py-2"
          :value="category.id"
        >
          <div>
            {{ category.name }}
          </div>
        </v-chip>
      </v-chip-group>
      <v-btn color="error" @click="del">削除</v-btn>
    </div>
    <v-table class="pa-5 rounded-lg">
      <thead>
        <tr>
          <th class="!tw-w-2 !tw-px-2">
            <input type="checkbox" v-model="selectAll" />
          </th>
          <th>カテゴリー</th>
          <th>イメージ</th>
          <th>追加日</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(albumn, i) in albumns" :key="i">
          <td class="!tw-w-2 !tw-px-2">
            <input type="checkbox" v-model="albumn.checked" />
          </td>
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
const selectAll = ref<boolean | null>(false);

searchCategories();
searchAlbums();

const handleFileChange = (event: Event) => {
  const input = event.target as HTMLInputElement;
  if (input.files) {
    filesToUpload.value = Array.from(input.files);
  }
};

/** チェックボックスの選択状態をwatch */
watch(selectAll, (newVal) => {
  albumns.value.forEach((albumn) => (albumn.checked = newVal));
});
watch(
  () => "albumns.*.checked",
  (newVal) => {
    albumns.value.forEach((albumn) => (albumn.checked = newVal));
    const allChecked = albumns.value.every((albumn) => albumn.checked);
    const someChecked = albumns.value.some((albumn) => albumn.checked);
    selectAll.value = allChecked ? true : someChecked ? null : false;
  }
);

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

async function del() {
  const ids = albumns.value
    .filter((item) => item.checked == true)
    .map((item) => item.id);

  if (ids.length == 0) {
    alert("削除対象を1件以上選択してください。");
  }
  await deleteAlbums(ids);
  searchAlbums();
}
</script>
