import {createRouter, createWebHashHistory, RouteRecordRaw} from 'vue-router'
import MainView from "@/views/MainView.vue";
import CreateFileView from "@/views/CreateFileView.vue";

const routes: Array<RouteRecordRaw> = [
    {
        path: '/',
        name: 'main',
        component: MainView,
    },
    {
        path: '/create',
        name: 'create',
        component: CreateFileView,
    }
]

const router = createRouter({
    history: createWebHashHistory(),
    routes
})

export default router
