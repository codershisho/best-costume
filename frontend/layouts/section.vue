<template>
  <div class="bg-back">
    <header class="tw-flex tw-justify-between tw-p-8">
      <div class="tw-w-48">
        <img src="../oddo_logo.png">
      </div>
      <div class="tw-flex tw-w-80 tw-gap-5">
        <v-text-field class="mr-2" bg-color="white" hide-details prepend-inner-icon="mdi-magnify" single-line
          density="compact" variant="solo" placeholder="衣装名を検索">
        </v-text-field>
        <NuxtLink to="favorite">
          <v-btn width="40px" height="40px" class="heart-color" density="default" icon="mdi-heart"></v-btn>
        </NuxtLink>
      </div>
    </header>
    <div class="tw-flex tw-h-full tw-p-6">
      <NuxtLink class="tw-px-10" :to="`/customer/${urlPathProductId}`">
        <v-btn width="40px" height="40px" density="default" icon="mdi-chevron-left"></v-btn>
      </NuxtLink>
      <div class="tw-w-full">
        <slot></slot>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
// urlパラメータのcustomerIdを取得（画面遷移で使用）
const urlPathProductId = useRoute().params.id

</script>