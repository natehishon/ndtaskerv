import VueRouter from "vue-router";


import Tasks from "./tasks/Tasks"
import Task from "./task/Task"
import SignIn from "./auth/SignIn"
import SignUp from "./auth/SignUp"
import AdminTools from "./admin/AdminTools"
import ManageTasks from "./admin/ManageTasks"
import ManageUsers from "./admin/ManageUsers"
import ManageUserFolders from "./admin/ManageUserFolders"
import ManageJargons from "./admin/ManageJargons"
import ManageJots from "./admin/ManageJots"
import store from "./store/index"
import TaskTrackings from "./taskTrackings/TaskTrackings";
import TaskTracking from "./taskTracking/TaskTracking";
import CreateTask from "./admin/CreateTask";
import EditTask from "./admin/EditTask";
import Profile from "./profile/Profile";
import Search from "./search/Search";
import Folders from "./folders/Folders";
import CreateJargon from "./jargons/CreateJargon";
import EditJargon from "./jargons/EditJargon";
import Jots from "./jots/Jots"
import UserJots from "./jots/UserJots"
import PrebuiltFolders from "./admin/PrebuiltFolders"
import PrebuiltFolder from "./admin/PrebuiltFolder"
import UserJargons from "./jargons/UserJargons"
import JargonPage from "./jargons/JargonPage";


const routes = [
    // {
    //     path: "/",
    //     component: Tasks,
    //     name: "home",
    //     beforeEnter: (to, from, next) => {
    //         if (!store.getters['auth/authenticated']) {
    //             return next({
    //                 name: 'signin'
    //             })
    //         }
    //         next()
    //     }
    // },
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
        path: "/edit-jargon/:id",
        component: EditJargon,
        name: "editJargon",
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/authenticated'] || !store.getters['auth/user'].isAdmin) {
                return next({
                    name: 'signin'
                })
            }
            next()
        }
    },
    {
        path: "/edit-task/:id",
        component: EditTask,
        name: "editTask",
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/authenticated'] || !store.getters['auth/user'].isAdmin) {
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
            if (!store.getters['auth/authenticated'] || !store.getters['auth/user'].isAdmin) {
                return next({
                    name: 'signin'
                })
            }
            next()
        }
    },
    {
        path: "/new-jargon",
        component: CreateJargon,
        name: "newJargon",
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/authenticated'] || !store.getters['auth/user'].isAdmin) {
                return next({
                    name: 'signin'
                })
            }
            next()
        }
    },
    {
        path: "/prebuilt-folders",
        component: PrebuiltFolders,
        name: "prebuiltFolder",
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/authenticated'] || !store.getters['auth/user'].isAdmin) {
                return next({
                    name: 'signin'
                })
            }
            next()
        }
    },
    {
        path: "/prebuilt-folders/:id",
        component: PrebuiltFolder,
        name: "prebuiltFolder",
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/authenticated'] || !store.getters['auth/user'].isAdmin) {
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
        path: "/jots",
        component: Jots,
        name: "jots",
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
        path: "/jargons",
        component: UserJargons,
        name: "jargons",
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
        path: "/manage-users",
        component: ManageUsers,
        name: "users",
        beforeEnter: (to, from, next) => {
            console.log(store.getters['auth/user'].isAdmin);
            if (!store.getters['auth/authenticated'] || !store.getters['auth/user'].isAdmin) {
                return next({
                    name: 'home'
                })
            }
            next()
        }
    },
    {
        path: "/manage-tasks",
        component: ManageTasks,
        name: "tasks",
        beforeEnter: (to, from, next) => {
            console.log(store.getters['auth/user'].isAdmin);
            if (!store.getters['auth/authenticated'] || !store.getters['auth/user'].isAdmin) {
                return next({
                    name: 'home'
                })
            }
            next()
        }
    },
    {
        path: "/manage-user-folders/:id",
        component: ManageUserFolders,
        name: "userFolders",
        beforeEnter: (to, from, next) => {
            console.log(store.getters['auth/authenticated']);
            if (!store.getters['auth/authenticated'] || !store.getters['auth/user'].isAdmin) {
                return next({
                    name: 'home'
                })
            }
            next()
        }
    },
    {
        path: "/jots/:id",
        component: UserJots,
        name: "userJots",
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/authenticated']) {
                return next({
                    name: 'home'
                })
            }
            next()
        }
    },
    {
        path: "/jargons/:id",
        component: JargonPage,
        name: "jargonPage",
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/authenticated']) {
                return next({
                    name: 'home'
                })
            }
            next()
        }
    },
    {
        path: "/manage-jargons",
        component: ManageJargons,
        name: "manageJargons",
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/authenticated'] || !store.getters['auth/user'].isAdmin) {
                return next({
                    name: 'home'
                })
            }
            next()
        }
    },
    {
        path: "/manage-jots",
        component: ManageJots,
        name: "manageJots",
        beforeEnter: (to, from, next) => {
            if (!store.getters['auth/authenticated'] || !store.getters['auth/user'].isAdmin) {
                return next({
                    name: 'home'
                })
            }
            next()
        }
    },
    {
        path: "/admin-tools",
        component: AdminTools,
        name: "adminTools",
        beforeEnter: (to, from, next) => {
            console.log(store.getters['auth/user'].isAdmin);
            if (!store.getters['auth/authenticated'] || !store.getters['auth/user'].isAdmin) {
                return next({
                    name: 'home'
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
        path: "/signup",
        component: SignUp,
        name: "signUp"
    },
    {
        path: "/signin",
        component: SignIn,
        name: "signin"
    },
    {
        path: '/*',
        component: Folders,
        // props: (route) => ({ name: route.query.q }),
        props: true,
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
];

const router = new VueRouter({
    routes,
    mode: "history",
    linkExactActiveClass: 'is-active',
});

export default router;
