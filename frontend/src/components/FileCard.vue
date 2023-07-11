<template>
    <div class="file-card" v-if="fileItem">
        <div class="file-card-title">{{fileItem.title}}.{{fileItem.extension}} ({{size}} МБ)</div>
        <div class="file-card-preview" v-if="fileItem.previewPath">
            <img :src="fileItem.previewPath" alt="">
        </div>
        <div class="file-card-actions">
            <div class="file-card-actions-edit" @click="onEdit">Редактировать</div>
            <div class="file-card-actions-delete" @click="onDelete">Удалить</div>
        </div>
    </div>
    <div class="file-card-empty" v-else>
        Loading...
    </div>
</template>

<script setup lang="ts">
import {FileItem} from "@/types/FileItem";
import {computed} from "vue";
import store from "@/store";

const onEdit = () => {
    store.commit('SET_SHOW_CONFIRM', true)
    store.commit('SET_CONFIRM_CALLBACK', () => {
        alert('to be implemented')
    })
}

const onDelete = () => {
    store.commit('SET_SHOW_CONFIRM', true)
    store.commit('SET_CONFIRM_CALLBACK', () => {
        store.dispatch('deleteFile', props.fileItem.id)
    })
}

const props = defineProps({
    fileItem: {
        type: FileItem,
        default: null
    }
})

const size = computed(() => {
    return Math.floor(props.fileItem?.size * 100) / 100;
})
</script>

<style lang="scss" scoped>
.file-card {
    background-color: #373737;
    height: calc((100vh - 42px) / 4);
    width: calc((100vw - 20px) / 4);
    color: #fff;
    padding: 10px;
    transition: .2s;
    display: flex;
    flex-direction: column;
    gap: 5px;

    * {
        opacity: 0.8;
        transition: .2s;
    }

    &-preview {
        width: 100px;
        height: 100px;
        img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    }

    &-actions {
        display: flex;
        margin-top: 10px;
        gap: 10px;
        opacity: 0;

        &-edit {
            color: #5187f1;
            cursor: pointer;
            &:hover {
                text-decoration: underline;
            }
        }

        &-delete {
            color: #f15151;
            cursor: pointer;
            &:hover {
                text-decoration: underline;
            }
        }
    }

    &:hover {
        background-color: #212121;
        * {
            opacity: 1;
        }
    }
    &-empty {

    }
}
</style>
