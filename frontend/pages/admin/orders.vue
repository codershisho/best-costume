<template>
  <div class="d-flex tw-justify-between tw-mb-4">
    <h2 class="tw-font-bold tw-text-xl tw-pt-2">注文リスト</h2>
  </div>
  <div class="mt-2">
    <v-sheet class="mb-3 pl-3 rounded-lg">
      <div class="d-flex tw-items-center">
        <v-chip-group class="tw-w-4/6 tw-gap-2" color="#E65100" variant="tonal" v-model="selectedStatus"
          @update:modelValue="filter">
          <v-chip v-for="(status, i) in statuses" :key="i" label :value="status.id" class="tw-w-24 !tw-m-0 tw-items-center tw-justify-center">
            <div>
              {{ status.name }}
            </div>
          </v-chip>
        </v-chip-group>
        <base-text class="ma-1" placeholder="search" clearable v-model="searchText" @click:clear="search"
          @update:modelValue="filter"></base-text>
        <v-btn class="tw-mx-3" variant="plain" density="compact" icon="mdi-swap-vertical"></v-btn>
      </div>
    </v-sheet>
    <v-table class="tw-px-2 rounded-lg">
      <thead>
        <tr>
          <th class="!tw-w-2 !tw-px-2"><input type="checkbox"></th>
          <th>顧客ID</th>
          <th>顧客</th>
          <th>電話番号</th>
          <th>注文日</th>
          <th>商品URL</th>
          <th>ステータス</th>
          <th>ステータス更新用</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(order, i) in orders" :key="i">
          <td class="!tw-w-2 !tw-px-2"><input type="checkbox"></td>
          <td>{{ order.customer_id }}</td>
          <td>{{ order.customer_name }}</td>
          <td>{{ order.customer_phone }}</td>
          <td>{{ order.created_at }}</td>
          <td>
            <a :href="order.product_url" target="_blank">商品サイト</a>
          </td>
          <td>
            <v-chip :color="order.status_color" label class="tw-w-24 !tw-m-0 tw-items-center tw-justify-center">
              {{ order.status_name }}
            </v-chip>
          </td>
          <td>
            <v-select v-model="order.status_id" :items="statuses" item-title="name" item-value="id" variant="solo-filled"
              flat density="compact" hide-details="auto" @update:modelValue="updateStatus(order)"></v-select>
          </td>
        </tr>
      </tbody>
    </v-table>
    <div>
      <v-pagination class="oddo_pagination tw-mt-2" v-model="page" :length="pageLength" density="compact"
        @update:modelValue="searchOrders"></v-pagination>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Order } from '~/types/product';

definePageMeta({
  layout: 'admin',
});

const { $showAlert } = useNuxtApp();
const orders = ref<Order[]>();
const statuses = ref();
const selectedStatus = ref(null);
const searchText = ref('');
const page = ref(1);
const pageLength = ref(1);

search();

async function search() {
  searhStatus();
  searchOrders();
}

/**
 * 注文一覧の検索
 */
async function searchOrders() {
  const { data } = await useApiFetch(
    `api/bc/admin/orders?page=${page.value}`
  );
  orders.value = data.value.data;
  pageLength.value = data.value.meta.last_page;
}

/**
 * 検索条件がある場合はセットして検索
 */
async function filter() {
  const params = {};
  if (searchText.value != '') {
    params.name = searchText.value;
  }
  if (selectedStatus.value != '' || selectedStatus.value == null) {
    params.status_id = selectedStatus.value;
  }
  const { data } = await useApiFetch(
    `/api/bc/admin/orders?page=${page.value}`,
    {
      method: 'get',
      params: params,
    }
  );
  orders.value = data.value.data;
  pageLength.value = data.value.meta.last_page;
}

/**
 * ステータス候補を検索
 */
async function searhStatus() {
  const { data } = await useApiFetch('/api/bc/master/statuses');
  statuses.value = data.value;
}

/**
 * ステータス更新
 */
async function updateStatus(order: Order) {
  console.log(order);
  const { data, status, error } = await useApiFetch(`api/bc/customer/${order.customer_id}/orders/${order.order_id}`, {
    method: 'put',
    body: {
      status_id: order.status_id
    }
  });
  if (status.value === 'success') {
    $showAlert('success', 'ステータス更新成功', data.value.message);
  } else if (status.value === 'error') {
    const errMessage = error.value.data.message;
    $showAlert('error', '失敗', errMessage);
  }

  searchOrders()
}
</script>

<style>
.oddo_pagination .v-pagination__list {
  justify-content: flex-end;
}
</style>