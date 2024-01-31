<template>
  <div class="d-flex flex-wrap tw-gap-4">
    <v-card v-for="n in 6" class="!tw-rounded-lg" width="228">
      <div>
        <div class="tw-p-4">
          <v-btn @click="addFavorite" width="40px" height="40px" class="!tw-absolute tw-top-4 tw-left-4 heart-color" density="default" icon="mdi-heart-outline"></v-btn>
          <NuxtLink to="/item">
            <v-img  aspect-ratio="1" contain src="1AO2811000.jpg"></v-img>
          </NuxtLink>
        </div>
        <div class="tw-font-bold tw-p-5">七五三レンタル(3歳男児被布)2811白兜xグレーブラウン</div>
      </div>
    </v-card>
  </div>
</template>

<script setup lang="ts">

definePageMeta({
  middleware: "auth"
});

const authStore = useAuthStore();

const favoriteIcon = ref("mdi-heart-outline");

const addFavorite = () => {
  favoriteIcon.value = "mdi-heart";
}

</script>
