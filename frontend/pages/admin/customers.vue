<template>
  <div class="d-flex tw-justify-between tw-mb-4">
    <h2 class="tw-font-bold tw-text-xl tw-pt-2">顧客リスト</h2>
    <dialog-customer @close="search"></dialog-customer>
  </div>
  <div class="mt-2">
    <v-sheet class="mb-3 pl-3 rounded-lg">
      <div class="d-flex tw-items-center">
        <base-text
          class="ma-1"
          placeholder="search"
          clearable
          v-model="searchText"
          @click:clear="search"
          @update:modelValue="filter"
        ></base-text>
        <v-btn
          class="tw-mx-3"
          variant="plain"
          density="compact"
          icon="mdi-swap-vertical"
        ></v-btn>
      </div>
    </v-sheet>
    <v-table class="tw-px-2 rounded-lg">
      <thead>
        <tr>
          <th class="!tw-w-2 !tw-px-2"><input type="checkbox" /></th>
          <th>顧客ID</th>
          <th>顧客</th>
          <th>電話番号</th>
          <th>来店日</th>
          <th>専用ページ</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(customer, i) in customers" :key="i">
          <td class="!tw-w-2 !tw-px-2"><input type="checkbox" /></td>
          <td>{{ customer.id }}</td>
          <td>{{ customer.name }}</td>
          <td>{{ customer.phone }}</td>
          <td>{{ customer.visit_date }}</td>
          <td>
            <v-icon color="#90A4AE" @click="jump(customer)"
              >mdi-page-next-outline</v-icon
            >
          </td>
        </tr>
      </tbody>
    </v-table>
    <div>
      <v-pagination
        class="oddo_pagination tw-mt-2"
        v-model="page"
        :length="pageLength"
        density="compact"
        @update:modelValue="searchCustomers"
      ></v-pagination>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Customer } from "~/types/customer";

definePageMeta({
  layout: "admin",
});

const customers = ref<Customer[]>();
const searchText = ref("");
const page = ref(1);
const pageLength = ref(1);

search();

async function search() {
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
  if (searchText.value != "") {
    params.name = searchText.value;
  }
  const { data } = await useApiFetch(
    `/api/bc/admin/customers/search?page=${page.value}`,
    {
      method: "get",
      params: params,
    }
  );
  customers.value = data.value.data;
  pageLength.value = data.value.meta.last_page;
}

function jump(customer: any) {
  navigateTo("/customer/" + customer.id);
}
</script>

<style>
.oddo_pagination .v-pagination__list {
  justify-content: flex-end;
}
</style>
