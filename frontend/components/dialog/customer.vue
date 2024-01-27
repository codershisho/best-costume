<template>
  <BaseButton
    text="新規作成"
    color="primary"
    @click="isActive = true"
  ></BaseButton>

  <v-dialog width="500" v-model="isActive">
    <v-card title="新規追加">
      <v-form v-model="valid">
        <div class="px-5 py-3">
          <div class="pa-2">顧客名</div>
          <BaseText
            placeholder="お客様名"
            :rules="[requiredValidation]"
            v-model="name"
          ></BaseText>
          <div class="pa-2">電話番号</div>
          <BaseText
            placeholder="電話番号"
            :rules="[requiredValidation]"
            v-model="phone"
          ></BaseText>
          <div class="d-flex mt-5">
            <BaseButton
              text="close"
              variant="outlined"
              @click="isActive = false"
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
const emit = defineEmits(["close"]);
const isActive = ref(false);
const name = ref("");
const phone = ref("");
const { $showAlert } = useNuxtApp();
// バリデーション
const valid = ref(false);
const requiredValidation = (v: any) => !!v || "必ず入力してください";

async function onSave() {
  await useApiFetch("/api/bc/admin/customers", {
    method: "post",
    body: {
      name: name,
      phone: phone,
    },
  });
  isActive.value = false;

  emit("close");
}
</script>
