<template>
  <v-dialog class="tw-text-center" width="364" v-model="value">
    <v-card>
      <div class="tw-p-8 tw-flex tw-flex-col tw-gap-6">
        <div>
          <div class="tw-text-left tw-mb-2 tw-font-bold tw-text-sm">
            ステータス名
          </div>
          <BaseText placeholder="ステータス" v-model="data.name"></BaseText>
        </div>
        <div>
          <div class="tw-text-left tw-mb-2 tw-font-bold tw-text-sm">
            ステータスカラー
          </div>
          <v-color-picker
            v-model="data.color"
            mode="hex"
            class="tw-m-auto"
          ></v-color-picker>
        </div>
        <div class="d-flex tw-justify-between">
          <BaseButton
            text="キャンセル"
            variant="outlined"
            @click="value = false"
            class="tw-w-[144px] tw-opacity-50"
          ></BaseButton>
          <v-spacer></v-spacer>
          <BaseButton
            text="作成"
            variant="tonal"
            color="primary"
            @click="onSave"
            class="tw-w-[144px]"
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
const emit = defineEmits(["update:modelValue"]);

const value = computed({
  get() {
    return props.modelValue;
  },
  set(value) {
    emit("update:modelValue", value);
  },
});

async function onSave() {
  if (props.isInsert) {
    store();
  } else {
    update();
  }
  value.value = false;
}

async function fetchData(url, method, body) {
  await useApiFetch(url, { method, body });
}

async function store() {
  await fetchData("/api/bc/master/statuses", "post", props.data);
}

async function update() {
  await fetchData(
    `/api/bc/master/statuses/${props.data.id}`,
    "put",
    props.data
  );
}
</script>
