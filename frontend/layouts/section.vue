<template>
  <div>
    <div class="tw-flex tw-justify-between tw-p-10">
    <p>STUDIO ODDD.</p>
    <v-btn density="default" icon="mdi-heart-outline"></v-btn>
    </div>
    <NuxtLink class="tw-px-10" to="/">
      <v-btn density="compact" icon="mdi-chevron-left"></v-btn>
    </NuxtLink>
    <v-container>
    <slot></slot>

    </v-container>
  </div>
</template>