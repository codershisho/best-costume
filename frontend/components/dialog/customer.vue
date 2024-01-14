<template>
  <BaseButton
    text="新規作成"
    color="primary"
    @click="isActive = true"
  ></BaseButton>

  <v-dialog width="500" v-model="isActive">
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
  </v-dialog>
</template>

<script setup lang="ts">
const emit = defineEmits(["close"]);
const isActive = ref(false);
const name = ref("");
const phone = ref("");
const { $swal } = useNuxtApp();

async function onSave() {
  await useApiFetch("/api/bc/admin/customers", {
    method: "post",
    body: {
      name: name,
      phone: phone,
    },
  });

  isActive.value = false;

  $swal.fire({
    title: "登録完了",
    icon: "success",
    toast: true,
    position: "top-end", //画面右上
    showConfirmButton: false,
    timer: 3000, //3秒経過後に閉じる
    background: "#2A73C5",
    color: "#FFFFFF",
  });

  emit("close");
}
</script>
