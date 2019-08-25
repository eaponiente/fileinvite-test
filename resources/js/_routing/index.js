import Vue from 'vue'
import VueRouter from 'vue-router'
import main from './main.routes'

Vue.use(VueRouter);

const routes = [
    ...main,
];

const router = new VueRouter({
    routes
});

export default router