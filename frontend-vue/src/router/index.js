import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        name: "transaction.index",
        component: () => import("../components/page/Index.vue"),
    },
    {
        path: "/create",
        name: "transaction.create",
        component: () => import("../components/page/Create.vue"),
    },
    {
        path: "/edit/:id",
        name: "transaction.edit",
        component: () => import("../components/page/Edit.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
