<template>
  <div class="d-flex">
    <div>顧客リスト</div>
    <v-spacer></v-spacer>
    <dialog-customer @close="search"></dialog-customer>
  </div>
  <div class="mt-3">
    <v-sheet class="mb-3 pl-3 rounded-lg">
      <v-chip-group color="#E65100" variant="tonal">
        <v-chip
          v-for="(status, i) in statuses"
          :key="i"
          label
          class="tw-w-1/12"
        >
          <div>
            {{ status.name }}
          </div>
        </v-chip>
      </v-chip-group>
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
  </div>
</template>

<script setup lang="ts">
import { Customer } from '~/types/customer';

definePageMeta({
  layout: 'admin',
});

const customers = ref<Customer[]>();
const statuses = ref();

search();

async function search() {
  searchCustomers();
  searhStatus();
}

async function searchCustomers() {
  const { data } = await useApiFetch('/api/bc/admin/customers');
  customers.value = data.value;
}

async function searhStatus() {
  const { data } = await useApiFetch('/api/bc/master/statuses');
  statuses.value = data.value;
}

function jump(customer) {
  navigateTo('/customer/' + customer.id);
}

// TODO 行クリック⇒詳細情報ページ
// TODO 専用ページ遷移
</script>
