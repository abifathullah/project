import { createRouter, createWebHistory } from 'vue-router';
import About from '../views/About.vue';
import ProductList from '../views/ProductList.vue';
import ProductDetail from '../views/ProductDetail.vue';
import Login from '../views/Login.vue';
import AddEditProduct from '../views/AddEditProduct.vue';

const routes = [
    {
        path: '/',
        name: 'Login',
        component: Login,
    },
    {
        path: '/about',
        name: 'About',
        component: About,
    },
    {
        path: '/home',
        name: 'Home',
        component: ProductList,
        meta: { requiresAuth: true },
    },
    {
        path: '/product/:id',
        name: 'ProductDetail',
        component: ProductDetail,
        meta: { requiresAuth: true },
    },
    {
        path: '/product/:id/edit',
        name: 'EditProduct',
        component: AddEditProduct,
        props: { mode: 'edit' },
    },
    {
        path: '/product/add',
        name: 'AddProduct',
        component: AddEditProduct,
        props: { mode: 'add' },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (!localStorage.getItem('token')) {
            next({ name: 'Login' });
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;
