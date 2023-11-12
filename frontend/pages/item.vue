<template>
  <div>
    <v-chip>カテゴリー</v-chip>
    <h2 class="tw-font-bold tw-text-2xl tw-my-4">商品名</h2>
    <div class="tw-flex tw-gap-16">
      <div class="tw-w-1/2">
        <v-img class="rounded-lg tw-w-full" aspect-ratio="1" cover
          src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"></v-img>
        <div class="tw-grid tw-grid-cols-4 tw-gap-4 tw-mt-4">
          <v-img class="rounded-lg tw-col-span-1 tw-w-40" aspect-ratio="1" cover
            src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"></v-img>
          <v-img class="rounded-lg tw-col-span-1 tw-w-40" aspect-ratio="1" cover
            src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"></v-img>
          <v-img class="rounded-lg tw-col-span-1 tw-w-40" aspect-ratio="1" cover
            src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"></v-img>
          <v-img class="rounded-lg tw-col-span-1 tw-w-40" aspect-ratio="1" cover
            src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"></v-img>
          <v-img class="rounded-lg tw-col-span-1 tw-w-40" aspect-ratio="1" cover
            src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"></v-img>
        </div>
      </div>
      <div class="tw-flex tw-w-1/2 tw-flex-col tw-justify-between">
        <p>■身丈：７６cm 肩裄：４２cm 袖丈：５７cm
          ※標準サイズに調整済みです。
          ※簡単なサイズ調整（腰紐にて）が必要な場合があります。
          ※小物は着物に合わせてコーディネートさせていただきます。
          ※総柄のため写真と少し異なることがあります。</p>
        <div class="tw-text-right">
          <p class="tw-font-bold tw-text-xl">¥10,000</p>
          <div class="tw-flex tw-justify-between tw-mt-4">
            <v-btn density="comfortable" icon="mdi-heart"></v-btn>
            <v-btn class="tw-w-32" color="primary">
              All
            </v-btn>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  layout: 'section',
});
</script>