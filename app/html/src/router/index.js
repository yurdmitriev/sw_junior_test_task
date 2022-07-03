import {createRouter, createWebHashHistory} from 'vue-router'
import HomeView from '../views/HomeView.vue'
import AddProductView from '../views/AddProductView.vue'

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomeView,
        meta: {
            title: "Products List"
        }
    },
    {
        path: '/add-product',
        name: 'add',
        component: AddProductView,
        meta: {
            title: "Product Add"
        }
    }
]

const router = createRouter({
    history: createWebHashHistory(),
    routes
})

export default router
