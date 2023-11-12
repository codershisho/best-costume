<template>
  <div>albumns</div>
  <div class="d-flex align-center">
    <v-file-input
      class="mr-5"
      label="upload"
      density="compact"
      hide-details
      multiple
      v-model="files"
    ></v-file-input>
    <BaseButton
      text="アップロード"
      color="primary"
      @click="upload"
    ></BaseButton>
  </div>
  <div></div>
</template>

<script setup lang="ts">
definePageMeta({
  layout: 'admin',
});

const files = ref([]);

async function upload() {
  const formData = new FormData();

  console.log(files);

  files.value.forEach((file, i) => {
    formData.append('file_' + i, file);
  });

  await useApiFetch('/api/bc/admin/albums/upload', {
    method: 'post',
    body: formData,
    headers: {
      'content-type': 'multipart/form-data',
    },
  });
}
</script>
