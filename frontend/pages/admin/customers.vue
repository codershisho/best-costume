<template>
  <div class="d-flex">
    <div>顧客リスト</div>
    <v-spacer></v-spacer>
    <dialog-customer @close="search"></dialog-customer>
  </div>
  <div class="mt-3">
    <v-sheet class="mb-3 pl-3 rounded-lg">
      <div class="d-flex">
        <v-chip-group
          class="tw-w-4/6"
          color="#E65100"
          variant="tonal"
          v-model="selectedStatus"
          @update:modelValue="filter"
        >
          <v-chip
            v-for="(status, i) in statuses"
            :key="i"
            label
            class="tw-w-1/12"
            :value="status.id"
          >
            <div>
              {{ status.name }}
            </div>
          </v-chip>
        </v-chip-group>
        <base-text
          class="ma-1"
          placeholder="search"
          clearable
          v-model="searchText"
          @click:clear="search"
          @update:modelValue="filter"
        ></base-text>
      </div>
    </v-sheet>
    <v-table class="pa-5 rounded-lg">
      <thead>
        <tr>
          <th>顧客ID</th>
          <th>顧客</th>
          <th>電話番号</th>
          <th>来店日</th>
          <th>ステータス</th>
          <th>専用ページ</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(customer, i) in customers" :key="i">
          <td>{{ customer.id }}</td>
          <td>{{ customer.name }}</td>
          <td>{{ customer.phone }}</td>
          <td>{{ customer.visit_date }}</td>
          <td>
            <v-chip :color="customer.status_color" label class="tw-w-10/12">
              {{ customer.status_name }}
            </v-chip>
          </td>
          <td>
            <v-icon color="#90A4AE" @click="jump(customer)"
              >mdi-page-next-outline</v-icon
            >
          </td>
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
import { Customer } from '~/types/customer';

definePageMeta({
  layout: 'admin',
});

const customers = ref<Customer[]>();
const statuses = ref();
const selectedStatus = ref(null);
const searchText = ref('');
const page = ref(1);
const pageLength = ref(1);

search();

async function search() {
  searhStatus();
  searchCustomers();
}

async function searchCustomers() {
  const { data } = await useApiFetch(
    `/api/bc/admin/customers?page=${page.value}`
  );
  customers.value = data.value.data;
  pageLength.value = data.value.meta.last_page;
}

async function filter() {
  const params = {};
  if (searchText.value != '') {
    params.name = searchText.value;
  }
  if (selectedStatus.value != '' || selectedStatus.value == null) {
    params.status_id = selectedStatus.value;
  }
  const { data } = await useApiFetch(
    `/api/bc/admin/customers/search?page=${page.value}`,
    {
      method: 'get',
      params: params,
    }
  );
  customers.value = data.value.data;
  pageLength.value = data.value.meta.last_page;
}

async function searhStatus() {
  const { data } = await useApiFetch('/api/bc/master/statuses');
  statuses.value = data.value;
}

function jump(customer: any) {
  navigateTo('/customer/' + customer.id);
}
</script>
