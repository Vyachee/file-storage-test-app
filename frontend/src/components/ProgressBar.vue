<template>
    <div class="progress">
        <div class="current" :style="{width: widthStyle}"></div>
    </div>
</template>

<script setup lang="ts">

import {computed} from "vue";
import store from "@/store";

const progressPercent = computed(() => {
    return store.state.uploadProgress;
})

const widthStyle = computed(() => {
    return `${progressPercent.value}%`;
})

</script>

<style lang="scss" scoped>
.progress {
    min-height: 50px;
    background-color: #ccc;
    position: relative;
    .current {
        height: 100%;
        background-color: #5696e6;
        position: absolute;
        top: 0;
        left: 0;
        transition: .2s;
    }
}
</style>
