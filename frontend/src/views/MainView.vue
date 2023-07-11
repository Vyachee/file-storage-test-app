<template>
  <div class="main" ref="container">
      <FileCard v-for="file in files" :file-item="file" :key="file.id" />
  </div>
</template>

<script lang="ts" setup>

import FileCard from "@/components/FileCard.vue";
import {computed, onMounted, ref} from "vue";
import store from "@/store";
import {useInfiniteScroll} from "@vueuse/core";

const files = computed(() => {
    return store.state.files;
})

const container = ref<HTMLElement | null>(null)
let debounce: any = null;
onMounted(() => {
    useInfiniteScroll(
        container,
        async () => {
            clearTimeout(debounce);
            debounce = setTimeout(async () => {
                const nextPage = store.state.meta.current_page + 1
                if(!(nextPage > store.state.meta.last_page)) {
                    await store.dispatch('fetchFiles', nextPage)
                }
            }, 500)
        },
        {direction: "top"}
    )
})
</script>

<style lang="scss">
.main {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1px;
    height: calc(100% - 50px);
    overflow-y: scroll;
}
</style>
