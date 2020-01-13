import VueRouter from "vue-router";

import Tasks from "./tasks/Tasks"
import Task from "./task/Task"
import SignIn from "./auth/SignIn"

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
    {
        path: "/signin",
        component: SignIn,
        name: "signin"
    }
];

const router = new VueRouter({
    routes,
    mode: "history",
});

export default router;