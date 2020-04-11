import VueRouter from "vue-router";


import Tasks from "./tasks/Tasks"
import Task from "./task/Task"
import SignIn from "./auth/SignIn"
import store from "./store/index"
import TaskTrackings from "./taskTrackings/TaskTrackings";
import TaskTracking from "./taskTracking/TaskTracking";
import CreateTask from "./admin/CreateTask";
import Profile from "./profile/Profile";
import Search from "./search/Search";
import Folders from "./folders/Folders";


const routes = [
    {
        path: "/",
        component: Tasks,
        name: "home",
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/authenticated']) {
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
            if (!store.getters['auth/authenticated']) {
                return next({
                    name: 'signin'
                })
            }
            next()
        }
    },
    // {
    //     path: "/task/:id",
    //     component: Task,
    //     name: "task",
    //     beforeEnter: (to, from, next) => {
    //         if(!store.getters['auth/authenticated']){
    //             return next({
    //                 name: 'signin'
    //             })
    //         }
    //         next()
    //     }
    // },
    {
        path: "/mytask/:id",
        component: TaskTracking,
        name: "mytask",
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/authenticated']) {
                return next({
                    name: 'signin'
                })
            }
            next()
        }
    },
    {
        path: "/new-task",
        component: CreateTask,
        name: "newTask",
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/authenticated']) {
                return next({
                    name: 'signin'
                })
            }
            next()
        }
    },
    {
        path: "/profile",
        component: Profile,
        name: "profile",
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/authenticated']) {
                return next({
                    name: 'signin'
                })
            }
            next()
        }
    },

    {
        path: '/search',
        component: Search,
        props: (route) => ({ search: route.query.q }),
        name: "search",
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/authenticated']) {
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
    },
    {
        path: '/folders*',
        component: Folders,
        props: (route) => ({ name: route.query.q }),
        name: "folders",
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/authenticated']) {
                return next({
                    name: 'signin'
                })
            }
            next()
        }
    },
];

const router = new VueRouter({
    routes,
    mode: "history",
    linkExactActiveClass: 'is-active',
});

export default router;