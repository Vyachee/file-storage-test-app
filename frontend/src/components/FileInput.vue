<template>
    <div class="input-file">
        <div class="drag-wrap"
             :class="{isDragging: dragging}"
             @dragenter="toggleClass"
             @dragleave="toggleClass"
             @drop="toggleClass"
        >
            <input type="file" @change="onFileInput">
            {{text}}
        </div>
    </div>
</template>

<script setup lang="ts">
import {computed, ref} from "vue";
const dragging = ref(false)
const file = ref<any>(null);
const emit = defineEmits(['fileLoaded'])
const onFileInput = (e: any) => {
    file.value = e.target.files[0];
    emit('fileLoaded', file.value);
}
const toggleClass = () => {
    dragging.value = !dragging.value
}

const text = computed(() => {
    if(dragging.value) {
        return 'Отпустите кнопку мыши!'
    }   else if(file.value) {
        return `Загружен файл: ${file.value.name}`
    }   else {
        return 'Перетащите файл в эту область или кликните здесь'
    }
})
</script>

<style lang="scss" scoped>
.drag-wrap {
    width: 100%;
    height: 100%;
    background-color: #cccccc;
    position: relative;
    min-height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;

    &.isDragging {
        background-color: #7db7c3;
    }


    input {
        width: 100%;
        height: 100%;
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;

    }
}
</style>
