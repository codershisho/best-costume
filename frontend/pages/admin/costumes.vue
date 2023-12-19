<template>
  <div class="d-flex tw-justify-between tw-mb-4">
    <h2 class="tw-font-bold tw-text-xl tw-pt-2">衣装リスト</h2>
    <NuxtLink to="/admin/costume">
      <v-btn color="primary">
        衣装登録
      </v-btn>
    </NuxtLink>
  </div>
  <div class="mt-2">
    <v-sheet class="mb-3 pl-3 rounded-lg">
      <div class="d-flex tw-items-center">
        <v-chip-group class="tw-w-4/6" color="#E65100" variant="tonal" v-model="selectedStatus"
          @update:modelValue="filter">
          <v-chip v-for="(status, i) in statuses" :key="i" label :value="status.id">
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
          <th>衣装ID</th>
          <th>衣装名</th>
          <th>カテゴリー</th>
          <th>ステータス</th>
          <th>登録日</th>
          <th>販売元</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(customer, i) in customers" :key="i">
          <td class="!tw-w-2 !tw-px-2"><input type="checkbox"></td>
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
            <v-icon color="#90A4AE" @click="jump(customer)">mdi-page-next-outline</v-icon>
          </td>
        </tr>
      </tbody>
    </v-table>
    <div>
      <v-pagination class="oddo_pagination tw-mt-2" v-model="page" :length="pageLength" density="compact"
        @update:modelValue="searchCustomers"></v-pagination>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  layout: 'admin',
});
</script>
