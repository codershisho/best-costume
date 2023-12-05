<template>
  <v-tabs v-model="tab" bg-color="deep-purple-accent-4" centered>
    <v-tab value="status">
      <v-icon class="mr-3">mdi-phone</v-icon>
      status
    </v-tab>

    <v-tab value="category">
      <v-icon class="mr-3">mdi-heart</v-icon>
      category
    </v-tab>
  </v-tabs>

  <v-window v-model="tab">
    <v-window-item :value="'status'">
      <BaseButton text="新規作成" color="primary" @click="onNew"></BaseButton>
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
            <th>カラーコード</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(status, i) in statuses" :key="i" @click="onRow(status)">
            <td>{{ status.id }}</td>
            <td>{{ status.name }}</td>
            <td>
              <v-btn :color="status.color"></v-btn>
            </td>
          </tr>
        </tbody>
      </v-table>
    </v-window-item>
    <v-window-item :value="'category'">
      <BaseButton
        text="新規作成"
        color="primary"
        @click="onNewCategory"
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
            <th>カラーコード</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(category, i) in categories"
            :key="i"
            @click="onRowCategory(category)"
          >
            <td>{{ category.id }}</td>
            <td>{{ category.name }}</td>
            <td>
              <v-btn :color="category.color"></v-btn>
            </td>
          </tr>
        </tbody>
      </v-table>
    </v-window-item>
  </v-window>
</template>

<script setup lang="ts">
definePageMeta({
  layout: 'admin',
});

const tab = ref('');
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
  const { data } = await useApiFetch('/api/bc/master/statuses');
  statuses.value = data.value;
}

async function searhCategory() {
  const { data } = await useApiFetch('api/bc/master/categories');
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
</script>
