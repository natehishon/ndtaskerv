import VueRouter from "vue-router";

import Tasks from "./tasks/Tasks"
import Task from "./task/Task"
import SignIn from "./auth/SignIn"
import store from "./store/index"
import TaskTrackings from "./taskTrackings/TaskTrackings";

const routes = [
    {
        path: "/",
        component: Tasks,
        name: "home",
        beforeEnter: (to, from, next) => {
            if(!store.getters['auth/authenticated']){
                return next({
                    name: 'signin'
                })
            }
            next()
        }
    },
    {
        path: "/my-tasks",
        component: TaskTrackings,
        name: "mytasks",
        beforeEnter: (to, from, next) => {
            if(!store.getters['auth/authenticated']){
                return next({
                    name: 'signin'
                })
            }
            next()
        }
    },
    {
        path: "/task/:id",
        component: Task,
        name: "task",
        beforeEnter: (to, from, next) => {
            if(!store.getters['auth/authenticated']){
                return next({
                    name: 'signin'
                })
            }
            next()
        }
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