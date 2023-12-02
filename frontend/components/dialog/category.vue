<template>
  <v-dialog width="500" v-model="value">
    <v-card title="新規追加">
      <div class="px-5 py-3">
        <div class="pa-2">カテゴリー</div>
        <BaseText placeholder="カテゴリー" v-model="data.name"></BaseText>
        <div class="pa-2">カラーコード</div>
        <v-color-picker v-model="data.color" mode="hex"></v-color-picker>
        <div class="d-flex">
          <BaseButton
            text="close"
            variant="outlined"
            @click="value = false"
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
  </v-dialog>
</template>

<script setup lang="ts">
const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false,
  },
  isInsert: {
    type: Boolean,
    default: false,
  },
  data: {
    type: Object,
    default: () => {},
  },
});

const { $showAlert } = useNuxtApp();
const emit = defineEmits(['update:modelValue']);

const value = computed({
  get() {
    return props.modelValue;
  },
  set(value) {
    emit('update:modelValue', value);
  },
});

async function onSave() {
  if (props.isInsert) {
    store();
  } else {
    update();
  }
}

async function fetchData(url, method, body) {
  const { data, status, error } = await useApiFetch(url, { method, body });

  if (status.value === 'success') {
    $showAlert('success', '成功', data.value.message);
  } else if (status.value === 'error') {
    const errMessage = error.value.data.message;
    $showAlert('error', '失敗', errMessage);
  }
}

async function store() {
  await fetchData('api/bc/master/categories', 'post', props.data);
}

async function update() {
  await fetchData(
    `api/bc/master/categories/${props.data.id}`,
    'put',
    props.data
  );
}
</script>
