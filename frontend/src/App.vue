<template>
    <div class="container">
        <ConfirmModal v-if="store.state.showConfirm"/>
        <nav>
            <router-link to="/">Главная</router-link>
            <router-link to="/create">Загрузить файл</router-link>
            <input
                type="text"
                class="search"
                v-model="query"
                placeholder="Введите название файла для поиска"
                v-if="router.currentRoute.value.name === 'main'"
            >
            <span v-if="router.currentRoute.value.name === 'main'">
                Отображено {{store.state.files.length}} из {{store.state.meta.total}} файлов
            </span>
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

const query = ref<string | null>(null);

let debounce: any = null;
watch(query, () => {
    clearTimeout(debounce);
    debounce = setTimeout(() => {
        const routerParams: RouteLocationRaw = {
            path: '/'
        }
        if(query.value) routerParams.query = {
            query: query.value
        }

        router.push(routerParams)
        store.commit('SET_QUERY', query.value)
        store.dispatch('fetchFiles')
    }, 300)
})

onMounted(async () => {
    await router.isReady()
    const q = router.currentRoute.value.query.query?.toString()
    if(q) {
        query.value = q;
        store.commit('SET_QUERY', q)
    }
    await store.dispatch('fetchFiles')
})

</script>

<style lang="scss">
#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: #2c3e50;
    width: 100vw;
    height: 100vh;
    overflow: hidden;
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
        span {
            color: #fff;
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
        height: 100%;
        background-color: #454545;
    }
}

</style>
