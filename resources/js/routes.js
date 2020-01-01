import VueRouter from "vue-router";

import Tasks from "./tasks/Tasks"
import Task from "./task/Task"

const routes = [
    {
        path: "/",
        component: Tasks,
        name: "home",
    },
    {
        path: "/task/:id",
        component: Task,
        name: "task",
    },
];

const router = new VueRouter({
    routes,
    mode: "history",
});

export default router;