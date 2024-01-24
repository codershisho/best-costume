<template>
  <div class="tw-bg-white tw-mb-4 tw-rounded-lg">
    <h2 class="tw-font-bold tw-text-xl tw-p-4">設定</h2>
    <v-tabs v-model="tab" class="tw-mb-6">
      <v-tab value="status">
        <v-icon class="mr-3">mdi-list-box-outline</v-icon>
        管理ステータス
      </v-tab>

      <v-tab value="category">
        <v-icon class="mr-3">mdi-image</v-icon>
        アルバムカテゴリー
      </v-tab>
    </v-tabs>
  </div>

  <v-window v-model="tab" class="tw-gap-6">
    <v-window-item :value="'status'" class="tw-flex tw-flex-col tw-gap-4">
      <BaseButton
        text="新規作成"
        color="primary"
        @click="onNew"
        class="tw-ml-auto tw-mr-0"
      ></BaseButton>
      <dialog-status
        v-model="dialog"
        :data="selectedRow"
        :isInsert="isInsert"
      ></dialog-status>
      <v-table class="pa-5 rounded-lg">
        <thead>
          <tr>
            <th>ID</th>
            <th>ステータス</th>
            <th>ステータスカラー</th>
            <th>アクション</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(status, i) in statuses" :key="i">
            <td>{{ status.id }}</td>
            <td>{{ status.name }}</td>
            <td>
              <v-btn :color="status.color"></v-btn>
            </td>
            <td>
              <div>
                <v-btn
                  class="mr-5"
                  density="compact"
                  flat
                  icon="mdi-pencil"
                  @click="onRow(status)"
                ></v-btn>
                <v-btn
                  density="compact"
                  flat
                  icon="mdi-trash-can"
                  @click="onDelete(status)"
                ></v-btn>
              </div>
            </td>
          </tr>
        </tbody>
      </v-table>
    </v-window-item>
    <v-window-item :value="'category'" class="tw-flex tw-flex-col tw-gap-4">
      <BaseButton
        text="新規作成"
        color="primary"
        @click="onNewCategory"
        class="tw-ml-auto tw-mr-0"
      ></BaseButton>
      <DialogCategory
        v-model="dialogCategory"
        :data="selectedRowCategory"
        :isInsert="isInsertCategory"
      ></DialogCategory>
      <v-table class="pa-5 rounded-lg">
        <thead>
          <tr>
            <th>ID</th>
            <th>カテゴリー名</th>
            <th>カテゴリーカラー</th>
            <th>アクション</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(category, i) in categories" :key="i">
            <td>{{ category.id }}</td>
            <td>{{ category.name }}</td>
            <td>
              <v-btn :color="category.color"></v-btn>
            </td>
            <td>
              <div>
                <v-btn
                  class="mr-5"
                  density="compact"
                  flat
                  icon="mdi-pencil"
                  @click="onRowCategory(category)"
                ></v-btn>
                <v-btn
                  density="compact"
                  flat
                  icon="mdi-trash-can"
                  @click="onDeleteC(category)"
                ></v-btn>
              </div>
            </td>
          </tr>
        </tbody>
      </v-table>
    </v-window-item>
  </v-window>
</template>

<script setup lang="ts">
definePageMeta({
  layout: "admin",
});

interface Status {
  id: number;
  name: string;
  color: string;
  created_at: string;
  updated_at: string;
  deleted_at: null;
}

interface Category {
  id: number;
  name: string;
  color: string;
  created_at: string;
  updated_at: string;
  deleted_at: null;
}

const tab = ref("");
const dialog = ref(false);
const dialogCategory = ref(false);

const statuses = ref([]);
const selectedRow = ref(null);
const isInsert = ref(false);

const categories = ref([]);
const selectedRowCategory = ref(null);
const isInsertCategory = ref(false);

searhStatus();
searhCategory();

async function searhStatus() {
  const { data } = await useApiFetch("/api/bc/master/statuses");
  statuses.value = data.value;
}

async function searhCategory() {
  const { data } = await useApiFetch("/api/bc/master/categories");
  categories.value = data.value;
}

function onNew() {
  isInsert.value = true;
  selectedRow.value = {};
  dialog.value = true;
}

function onRow(status) {
  isInsert.value = false;
  selectedRow.value = status;
  dialog.value = true;
}

const onDelete = async (status: Status) => {
  await deleteStatus(status.id);
};

function onNewCategory() {
  isInsertCategory.value = true;
  selectedRowCategory.value = {};
  dialogCategory.value = true;
}

function onRowCategory(category) {
  isInsertCategory.value = false;
  selectedRowCategory.value = category;
  dialogCategory.value = true;
}

const onDeleteC = async (category: Category) => {
  await deleteCategory(category.id);
};
</script>
