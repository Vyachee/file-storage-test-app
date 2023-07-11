<template>
    <input type="text" v-model="text" @input="$emit('inputText', text)" :placeholder="placeholder">
</template>

<script setup lang="ts">
    import {ref} from "vue";

    const text = ref(null)

    const props = defineProps({
        placeholder: {
            type: String,
            default: 'default placeholder'
        }
    })
</script>

<style lang="scss" scoped>
    input {
        padding: 10px 20px;
        border: none;
        outline: none;
        font-size: 18px;
        width: 100%;
    }
</style>
