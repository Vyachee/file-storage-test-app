<template>
  <div class="create-file">
      <div class="window">
          <h2>Загрузка нового файла</h2>
          <InputText placeholder="Введите название файла" @inputText="onChange"/>
          <FileInput @file-loaded="onFileLoaded"/>
          <div class="confirm" @click="confirm">Загрузить</div>
      </div>
  </div>
</template>

<script setup lang="ts">

import InputText from "@/components/InputText.vue";
import {ref} from "vue";
import FileInput from "@/components/FileInput.vue";
import store from "@/store";

const text = ref(null);
const file = ref(null);

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
    const payload = {
        title: text.value,
        attachment: file.value
    }

    store.dispatch('createFile', payload)
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
    }
}
</style>
