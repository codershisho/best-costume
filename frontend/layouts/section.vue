<template>
  <div>
    <div class="tw-flex tw-justify-between tw-p-10">
      <p>STUDIO ODDD.</p>
      <div class="tw-flex tw-w-80 tw-gap-5">
        <v-text-field class="mr-2" bg-color="white" hide-details prepend-inner-icon="mdi-magnify" single-line
          density="compact" variant="solo" placeholder="衣装名を検索">
        </v-text-field>
        <v-btn density="default" icon="mdi-heart-outline"></v-btn>
      </div>
    </div>
    <NuxtLink class="tw-px-10" to="/">
      <v-btn density="compact" icon="mdi-chevron-left"></v-btn>
    </NuxtLink>
    <v-container>
      <slot></slot>
    </v-container>
  </div>
</template>