<template>
  <v-dialog width="500">
    <template v-slot:activator="{ props }">
      <BaseButton v-bind="props" text="新規作成" color="primary"></BaseButton>
    </template>

    <template v-slot:default="{ isActive }">
      <v-card title="新規追加">
        <div class="px-5 py-3">
          <div class="pa-2">顧客名</div>
          <BaseText placeholder="お客様名" v-model="name"></BaseText>
          <div class="pa-2">電話番号</div>
          <BaseText placeholder="電話番号" v-model="phone"></BaseText>
          <div class="d-flex">
            <BaseButton
              text="close"
              variant="outlined"
              @click="isActive.value = false"
            ></BaseButton>
            <v-spacer></v-spacer>
            <BaseButton
              text="save"
              variant="tonal"
              color="primary"
              @click="onSave"
            ></BaseButton>
          </div>
        </div>
      </v-card>
    </template>
  </v-dialog>
</template>

<script setup lang="ts">
const name = ref('');
const phone = ref('');

async function onSave() {
  await useApiFetch('api/bc/admin/customers', {
    method: 'post',
    body: {
      name: name,
      phone: phone,
    },
  });
  // TODO sweet alart
}
</script>
