<template>
  <div class="main">
      <FileCard v-for="file in files" :file-item="file" :key="file.id" />
  </div>
</template>

<script lang="ts" setup>

import FileCard from "@/components/FileCard.vue";
import {computed} from "vue";
import store from "@/store";

const files = computed(() => {
    return store.state.files;
})
</script>

<style lang="scss">
.main {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1px;
    background-color: #454545;
    height: 100%;
}
</style>
