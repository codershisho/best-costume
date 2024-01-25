<template>
  <v-dialog width="500" v-model="value">
    <v-card title="顧客情報更新">
      <v-form v-model="valid">
        <div class="px-5 py-3">
          <div class="pa-2">顧客名</div>
          <BaseText
            placeholder="お客様名"
            :rules="[requiredValidation]"
            v-model="data.name"
          ></BaseText>
          <div class="pa-2">電話番号</div>
          <BaseText
            placeholder="電話番号"
            :rules="[requiredValidation]"
            v-model="data.phone"
          ></BaseText>
          <div class="d-flex mt-5">
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
              :disabled="!valid"
              @click="onSave"
            ></BaseButton>
          </div>
        </div>
      </v-form>
    </v-card>
  </v-dialog>
</template>

<script setup lang="ts">
const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false,
  },
  data: {
    type: Object,
    default: () => {},
  },
});
const emit = defineEmits(["close", "update:modelValue"]);
const value = computed({
  get() {
    return props.modelValue;
  },
  set(value) {
    emit("update:modelValue", value);
  },
});
const name = ref("");
const phone = ref("");
const { $showAlert } = useNuxtApp();
// バリデーション
const valid = ref(false);
const requiredValidation = (v: any) => !!v || "必ず入力してください";

async function onSave() {
  const { data, status, error } = await useApiFetch(
    `/api/bc/admin/customers/${props.data.id}`,
    {
      method: "put",
      body: props.data,
    }
  );

  if (status.value == "success") {
    $showAlert("success", "成功", data.value.message);
  } else if (status.value == "error") {
    const errMessage = error.value.data.message;
    $showAlert("error", "失敗", errMessage);
  }

  value.value = false;
}
</script>
