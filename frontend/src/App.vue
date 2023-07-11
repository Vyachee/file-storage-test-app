<template>
    <div class="container">
        <ConfirmModal v-if="store.state.showConfirm"/>
        <nav>
            <router-link to="/" @click="store.commit('SET_PAGE', 'main')">Главная</router-link>
            <router-link to="/create"  @click="store.commit('SET_PAGE', 'create')">Загрузить файл</router-link>
            <input
                type="text"
                class="search"
                v-model="query"
                placeholder="Введите название файла для поиска"
                v-if="store.state.currentPage === 'main'"
            >
        </nav>
        <div class="content">
            <router-view/>
        </div>
    </div>
</template>

<script setup lang="ts">
import store from "@/store";
import {onMounted, ref, watch} from "vue";
import router from "@/router";
import {RouteLocationRaw} from "vue-router";
import ConfirmModal from "@/components/ConfirmModal.vue";

const query = ref(null);

let debounce = null;
watch(query, () => {
    debounce = null;
    debounce = setTimeout(() => {
        const routerParams: RouteLocationRaw = {
            path: '/'
        }
        if(query.value) routerParams.query = {
            query: query.value
        }

        router.push(routerParams)
        store.dispatch('fetchFiles', {
            query: query.value
        })
    }, 300)
})

onMounted(() => {
    store.dispatch('fetchFiles')
})

</script>

<style lang="scss">
#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: #2c3e50;
}

* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

.container {
    width: 100vw;
    height: 100vh;
    display: flex;
    flex-direction: column;

    nav {
        padding: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 0;
        background-color: #2e2e2e;
        min-height: 50px;
        input {
            border: none;
            outline: none;
            width: 300px;
            margin-left: 20px;
            padding: 7px;
        }

        a {
            font-weight: bold;
            color: #999999;
            text-decoration: none;
            transition: .2s;

            &.router-link-exact-active {
                color: #fff;
            }
        }
    }

    .content {
        flex: 1;
        overflow-y: scroll;
        height: 100%;
    }
}

</style>
