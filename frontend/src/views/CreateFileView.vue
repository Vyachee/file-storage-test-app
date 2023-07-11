<template>
  <div class="create-file">
      <div class="window">
          <h2 v-if="!editId">Загрузка нового файла</h2>
          <h2 v-else>Редактирование файла #{{editId}}</h2>
          <InputText placeholder="Введите название файла" @inputText="onChange"/>
          <FileInput @file-loaded="onFileLoaded"/>
          <ProgressBar />
          <div class="confirm" @click="confirm">Загрузить</div>
          <div class="delete" @click="deleteFile" v-if="editId">Удалить</div>

      </div>
  </div>
</template>

<script setup lang="ts">

import InputText from "@/components/InputText.vue";
import {computed, ref, watch} from "vue";
import FileInput from "@/components/FileInput.vue";
import store from "@/store";
import router from "@/router";
import {useRoute} from "vue-router";
import ProgressBar from "@/components/ProgressBar.vue";

const text = ref(null);
const file = ref(null);

const route = useRoute();
const editId = computed(() => route.query.id)



const onChange = (e: any) => {
    text.value = e;
    console.log(text.value)
}

const onFileLoaded = (e: any) => {
    file.value = e;
    console.log('file:')
    console.log(e)
}

const confirm = () => {
    if(!editId.value) {
        const payload = {
            title: text.value,
            attachment: file.value
        }

        store.dispatch('createFile', payload)
        return
    }

    // Edit logic

    store.commit('SET_SHOW_CONFIRM', true)
    store.commit('SET_CONFIRM_CALLBACK', () => {

        const payload = {
            title: text.value,
            attachment: file.value
        }
        store.dispatch('createFile', payload)
        store.commit('SET_SHOW_CONFIRM', false)
    })

}

const deleteFile = () => {
    store.commit('SET_SHOW_CONFIRM', true)
    store.commit('SET_CONFIRM_CALLBACK', async () => {
        await store.dispatch('deleteFile', editId.value)
        await router.push({path: '/'})
    })
}
</script>

<style lang="scss" scoped>
.create-file {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 50px 0;
    .window {
        width: 80%;
        background-color: #373737;
        padding: 10px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        h2 {
            color: #fff;
        }
        .confirm {
            background-color: #86bef6;
            text-align: center;
            padding: 10px;
            cursor: pointer;
            transition: .3s;

            &:hover {
                background-color: #7099c3;
            }
        }
        .delete {
            background-color: #f68686;
            text-align: center;
            padding: 10px;
            cursor: pointer;
            transition: .3s;

            &:hover {
                background-color: #bc6565;
            }
        }
    }
}
</style>
