<template>
  <v-dialog max-width="800" v-model="props.open">
    <v-card title="衣装情報更新">
      <v-form v-model="valid" v-if="store.editProduct">
        <div class="px-5 py-3">
          <BaseText
            class="pb-3"
            placeholder="商品名"
            :rules="[requiredValidation]"
            v-model="store.editProduct.name"
          ></BaseText>
          <v-select
            class="py-3"
            :items="store.menus"
            placeholder="親メニュー"
            item-value="id"
            item-title="name"
            variant="solo-filled"
            flat
            density="compact"
            hide-details="auto"
            :rules="[requiredValidation]"
            v-model="parent"
            @update:model-value="selectedMenu = null"
          />
          <v-select
            class="py-3"
            :items="children"
            placeholder="子メニュー"
            item-value="id"
            item-title="name"
            variant="solo-filled"
            flat
            density="compact"
            :rules="[requiredValidation]"
            hide-details="auto"
            v-model="selectedMenu"
          />
          <BaseText
            class="py-3"
            placeholder="金額"
            v-model="store.editProduct.price"
            :rules="[requiredValidation]"
          ></BaseText>
          <v-textarea
            class="py-3"
            rows="10"
            placeholder="商品説明"
            v-model="store.editProduct.description"
            :rules="[requiredValidation]"
          ></v-textarea>
          <template v-if="store.editProduct.scrape_site_id == 0">
            <p class="mb-3 tw-text-slate-600">商品画像</p>
            <input
              type="file"
              multiple
              accept=".jpg, .jpeg, .png"
              @change="handleFileChange"
            />
          </template>
        </div>
      </v-form>
      <div class="d-flex px-5 py-3">
        <BaseButton text="close" variant="outlined" @click="close"></BaseButton>
        <v-spacer></v-spacer>
        <BaseButton
          text="save"
          variant="tonal"
          color="primary"
          :disabled="!valid"
          @click="onSave"
        ></BaseButton>
      </div>
    </v-card>
  </v-dialog>
</template>

<script setup lang="ts">
import { useCostumeStore } from "~/stores/costume";
const props = defineProps({
  open: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["update:open"]);
const valid = ref(false);
const store = useCostumeStore();
const requiredValidation = (v: any) => !!v || "必ず入力してください";
// メニュー関連
const parent = ref(null);
const selectedMenu = ref(null);
const children = computed(() => {
  if (parent.value == null) {
    return [];
  }
  return store.menus?.find((menu) => menu.id === parent.value)?.children || [];
});

onMounted(() => {
  console.log("mounted");
});
watch(
  () => props.open,
  (newValue, oldValue) => {
    if (newValue) {
      parent.value = store.parentMenu;
      selectedMenu.value = store.selectedMenuId;
    }
  }
);

const close = () => {
  emit("update:open", false);
};
/** ファイル選択 */
const handleFileChange = (event: Event) => {
  const input = event.target as HTMLInputElement;
  if (input.files && store.editProduct) {
    store.editProduct.images = Array.from(input.files);
  }
};
const onSave = async () => {
  store.editProduct.category_id = selectedMenu.value;
  const formData = new FormData();
  if (store.editProduct && store.editProduct.images != null) {
    store.editProduct.images.forEach((file) => {
      formData.append("files[]", file);
    });
  }
  for (const key of Object.keys(store.editProduct)) {
    formData.append(key, store.editProduct[key]);
  }

  await useApiFetch(`/api/bc/master/products/${store.editProduct?.id}/edit`, {
    method: "post",
    body: formData,
  });
  close();
};
</script>
