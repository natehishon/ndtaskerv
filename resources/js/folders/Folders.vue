<template>

    <div class="">


        <div class="folder-table mt-4">
            <b-row>
                <b-col cols="10" offset-sm="1">

                    <!--                    <b-alert show dismissible>-->
                    <!--                        welcome to wayfinder-->
                    <!--                    </b-alert>-->

                    <div class="breadcrumb-container">
                        <ul class="breadcrumb-ul">
                            <li v-for="(crumb, index) in breadCrumbs" v-if="crumb" @click="crumbClick(index)"><span>{{crumb}}</span>
                            </li>
                        </ul>

                        <div class="search-container">
                            <b-button size="sm" @click="openSearchModal()" variant="light" class="search-button">
                                <i class="fas fa-search"></i>&nbsp;search
                            </b-button>
                        </div>

                    </div>

                    <b-table
                        :items="folders"
                        :fields="fields"
                        ref="selectableTable"
                        @row-clicked="choose"
                        responsive="sm"

                        :tbody-tr-class="rowClass">

                        <template v-slot:cell(image)="data">
                            <div style="height: 100px;">
                                <img v-bind:src="data.item.image_url" style="height: 100px;">
                            </div>
                        </template>

                        <template v-slot:cell(type)="data">
                            <div>
                                <b-badge variant="info" v-if="data.item.type === 'task'"><i
                                    class="fas fa-list fa-fw"></i>&nbsp;task
                                </b-badge>
                                <b-badge variant="primary" v-if="data.item.type === 'folder'"><i
                                    class="fas fa-folder fa-fw"></i>&nbsp;folder
                                </b-badge>
                                <!--                                <i v-bind:class="{ 'fas fa-list-alt': data.item.type === 'task', 'fas fa-folder': data.item.type === 'folder' }"></i>-->
                                <!--                                <span>{{data.item.type}}-->
                            </div>
                        </template>

                    </b-table>

                    <b-modal footer-bg-variant=""
                             footer-text-variant="light"
                             id="modalID" size="xl"
                             :title="task.title"
                             @hide="taskClose"

                    >
                        <Task v-on:task-slide="changeSlide" :task="task" :sub="subTaskCopy"
                              :current-index="currentSlide" @indexchange="indexChange($event)"></Task>
                        <template v-slot:modal-footer>
                            <BottomNotch v-if="task" :sub-tasks="subTaskCopy"
                                         :current-slide="currentSlide"></BottomNotch>
                        </template>
                    </b-modal>
                </b-col>

            </b-row>
        </div>


        <b-modal
            id="searchModal" size="xl"

        >
            <template v-slot:modal-title>
                <i id="search-pop" class="fas fa-info-circle" style="font-size: 20px; cursor: pointer"></i>
                search
                <b-popover target="search-pop" triggers="hover blur" placement="top">
                    <b-row>
                        <b-col xs="12">
                            <span>search for something, you can click on your section to open it.</span>
                        </b-col>
                    </b-row>
                </b-popover>
            </template>
            <div class="container-fluid search-component">
                <b-row>
                    <b-col cols="10" offset-sm="1" class="search-form-container">
                        <b-input
                            v-model="searchQuery"
                            class="mb-2 mr-sm-2 mb-sm-0"
                            placeholder="search for something"
                            v-on:keyup.enter="search()"
                        ></b-input>
                        <b-button style="width: 130px;" size="md" @click="search()" variant="primary" class="search-button">
                            <i class="fas fa-search"></i>&nbsp;search
                        </b-button>
                    </b-col>
<!--                    <b-col cols="2">-->
<!--                        <div class="search-button-container">-->
<!--                            -->
<!--                        </div>-->

<!--                    </b-col>-->
                </b-row>

                <b-row>
                    <b-col cols="10" offset-sm="1">


                        <div class="tasks-container" v-if="searchResponse.folders.length > 0">
                            folders:
                            <div class="search-card-container">
                                <b-card v-for="(result, index) in searchResponse.folders" style="width: 17rem; cursor: pointer" :key="index" @click="searchFolderSelect(result)" >

                                    <b-card-text class="search-card-title">
                                        <v-runtime-template :template="'<div>' + result.highlightedTitle + '</div>'"/>
                                    </b-card-text>

                                </b-card>
                            </div>
                        </div>

                        <div class="search-result-container">
                            <div class="tasks-container" v-if="searchResponse.tasks.length > 0">
                                tasks:
                                <div class="search-card-container">
                                    <b-card v-for="(result, index) in searchResponse.tasks" style="max-width: 17rem; cursor: pointer" :key="index" @click="searchTaskSelect(result)">

                                        <b-card-title class="search-card-title">
                                            <v-runtime-template :template="'<div>' + result.highlightedTitle + '</div>'"/>
                                        </b-card-title>
                                        <hr>

                                        <b-card-text>
                                            <v-runtime-template :template="'<div>' + result.highlightedContent + '</div>'"/>
                                        </b-card-text>

                                    </b-card>
                                </div>

<!--                                <ul class="search-list">-->
<!--                                    <li v-for="(result, index) in searchResponse.tasks"-->
<!--                                        class="search-list-item"-->
<!--                                        @click="searchTaskSelect(result)">-->

<!--                                        title:-->
<!--                                        <v-runtime-template :template="'<div>' + result.highlightedTitle + '</div>'"/>-->
<!--                                        <br>-->
<!--                                        content:-->
<!--                                        <v-runtime-template :template="'<div>' + result.highlightedContent + '</div>'"/>-->

<!--                                    </li>-->
<!--                                </ul>-->
                            </div>
                        </div>

                        <div class="tasks-container" v-if="searchResponse.subTasks.length > 0">

                            task steps:
                            <div class="search-card-container">
                                <b-card v-for="(result, index) in searchResponse.subTasks" style="width: 18rem; cursor: pointer" :key="index" @click="searchSubSelect(result)" >

                                    <b-card-title class="search-card-title">
                                        <v-runtime-template :template="'<div>' + result.highlightedTitle + '</div>'"/>
                                    </b-card-title>
                                    <hr>

                                    <b-card-text>
                                        <v-runtime-template :template="'<div>' + result.highlightedContent + '</div>'"/>
                                    </b-card-text>

                                </b-card>
                            </div>

                        </div>

                        <div class="tasks-container" v-if="searchResponse.jots.length > 0">
                            jots:
                            <div class="search-card-container">
                                <b-card v-for="(result, index) in searchResponse.jots" style="width: 18rem; cursor: pointer" :key="index" @click="jotSelect(result)">

                                    <b-card-title class="search-card-title">
                                        <v-runtime-template :template="'<div>' + result.highlightedTitle + '</div>'"/>
                                    </b-card-title>
                                    <hr>

                                    <b-card-text>
                                        <v-runtime-template :template="'<div>' + result.highlightedContent + '</div>'"/>
                                    </b-card-text>

                                </b-card>
                            </div>
                        </div>

                        <div class="tasks-container" v-if="searchResponse.jotConvo.length > 0">
                            jot conversation:
                            <div class="search-card-container">
                                <b-card v-for="(result, index) in searchResponse.jotConvo" style="width: 18rem; cursor: pointer" :key="index" @click="jotConvoSelect(result)">

                                    <b-card-text>
                                        <v-runtime-template :template="'<div>' + result.highlightedContent + '</div>'"/>
                                    </b-card-text>

                                </b-card>
                            </div>
                        </div>

                        <div class="tasks-container" v-if="searchResponse.jargons.length > 0">
                            jargons:
                            <div class="search-card-container">
                                <b-card v-for="(result, index) in searchResponse.jargons" style="width: 18rem; cursor: pointer" :key="index"  @click="jargonSelect(result)">

                                    <b-card-title class="search-card-title">
                                        <v-runtime-template :template="'<div>' + result.highlightedTitle + '</div>'"/>
                                    </b-card-title>
                                    <hr>

                                    <b-card-text>
                                        <v-runtime-template :template="'<div>' + result.highlightedContent + '</div>'"/>
                                    </b-card-text>

                                </b-card>
                            </div>
                        </div>

                    </b-col>
                </b-row>

            </div>

            <template v-slot:modal-footer>
                <b-button size="md" @click="close" variant="secondary" class="search-button">
                    <i class="fas fa-times"></i>&nbsp;cancel
                </b-button>
            </template>
        </b-modal>

    </div>

</template>

<script>

    import axios from 'axios';
    import Task from '../task/Task'
    import BottomNotch from '../jots/BottomNotch'
    import VRuntimeTemplate from "v-runtime-template";

    export default {
        components: {
            Task,
            BottomNotch,
            VRuntimeTemplate,
        },

        props: ['test'],

        data() {
            return {
                folders: null,
                searchQuery: "",
                searchResponse: {
                    tasks: [],
                    folders: [],
                    jargons: [],
                    subTasks: [],
                    jots: [],
                    jotConvo: []
                },
                fields: [
                    {key: 'image', sortable: false, tdClass: 'imageColumn', thClass: 'imageHeader table-header'},
                    {key: 'title', sortable: true, thClass: 'table-header'},
                    {key: 'type', sortable: true, thClass: 'table-header', class: "type-class"},

                ],
                task: {id: "0", title: "", sub_task: []},
                subTaskCopy: [],
                currentSlide: 0,
                breadCrumbs: ['home']
            }
        },
        methods: {

            indexChange(event) {
                this.currentSlide = event
            },

            openSearchModal() {
                this.$bvModal.show("searchModal");
            },

            crumbClick(crumb) {
                let url = "";
                for (let i = 1; i <= crumb; i++) {
                    url += "/" + this.breadCrumbs[i];
                }


                // window.location.href = window.location.origin + url;
                if (url) {
                    this.$router.replace({path: url})
                } else {
                    this.$router.replace({name: 'home'})
                }

            },
            taskClose() {
                this.subTaskCopy = this.task.sub_task
                this.currentSlide = 0;
                this.$router.push(this.$route.path)
            },
            choose(row) {

                if (row.type === 'task') {
                    this.task = row;

                    if (this.task.sub_task.length > 0) {
                        this.subTaskCopy = JSON.parse(JSON.stringify(this.task.sub_task));
                        let startSub = {
                            title: "start!",
                            taskTitle: this.task.title,
                            content_html: this.task.content_html,
                            image_url: this.task.image_url,
                            media_type: this.task.media_type,
                            searchType: this.task.searchType,
                            id: this.task.id,
                            task: false
                        }
                        this.subTaskCopy.unshift(startSub);
                    } else {
                        this.subTaskCopy = [
                            {
                                taskTitle: this.task.title,
                                id: this.task.id,
                                searchType: this.task.searchType,
                                task: true
                            }
                        ];
                    }
                    this.$bvModal.show("modalID");
                }

                if (row.type === 'folder') {
                    this.$router.push(this.$router.currentRoute.path + '/' + row.slug)
                }
            },

            changeSlide(event) {
                this.currentSlide = event
            },
            rowClass(item, type) {
                if (!item || type !== 'row') return
            },

            searchFolderSelect(result) {
                console.log(result);
                console.log(this.$router.currentRoute.path);

                if("/"+result.fullSlug == this.$router.currentRoute.path){
                    this.$bvModal.hide("searchModal");
                    return;

                }

                if (this.$router.currentRoute.path === "/") {
                    this.$router.replace({path: `${result.fullSlug}`});
                    // this.$router.push({ path: `${result.fullSlug}`, params: {test: result.id}})
                } else {
                    this.$router.push({name: 'home'},
                        () => this.$router.replace({path: `${result.fullSlug}`}))
                }
            },

            searchSubSelect(result) {
                if (this.$router.currentRoute.path === "/") {
                    this.$router.replace({
                        path: `${result.fullSlug}`,
                        query: {taskID: result.taskid, subTaskID: result.id}
                    })
                    // this.$router.push({ path: `${result.fullSlug}`, params: {test: result.id}})
                } else {
                    this.$router.push({name: 'home'},
                        () => this.$router.replace({
                            path: `${result.fullSlug}`,
                            query: {taskID: result.taskid, subTaskID: result.id}
                        }))
                }
            },

            searchTaskSelect(result) {

                if (this.$router.currentRoute.path === "/") {
                    this.$router.replace({path: `${result.fullSlug}`, query: {taskID: result.id}})
                } else {
                    this.$router.push({name: 'home'},
                        () => this.$router.replace({path: `${result.fullSlug}`, query: {taskID: result.id}}))
                }
            },

            traverse(object, slug) {

                slug = object.slug + '/' + slug;

                if (object.all_parents) {
                    return this.traverse(object.all_parents, slug)
                } else {
                    return slug;
                }
            },

            highlight(content) {

                if (!this.searchQuery) {
                    return content;
                }

                let searchArray = this.searchQuery.split(" ")

                searchArray.forEach(word => {

                    content = content.replace(new RegExp(word, "gim"), match => {
                        return '<span class="highlightText">' + match + '</span>';
                    });

                });

                return content;
            },

            search() {

                let formData = {
                    search: this.searchQuery
                }

                axios.post('search/user-search', formData).then(response => {

                    this.searchResponse = response.data;

                    if (this.searchResponse.tasks) {
                        for (let child of this.searchResponse.tasks) {
                            child.fullSlug = this.traverse(child, "");
                            child.highlightedTitle = this.highlight(child.title);
                            child.highlightedContent = this.highlight(child.content);
                        }
                    }

                    if (this.searchResponse.folders) {
                        for (let child of this.searchResponse.folders) {
                            child.fullSlug = this.traverse(child, "");
                            child.highlightedTitle = this.highlight(child.title);
                        }
                    }

                    if (this.searchResponse.subTasks) {
                        for (let child of this.searchResponse.subTasks) {
                            child.fullSlug = this.traverse(child, "");
                            child.highlightedTitle = this.highlight(child.title);
                            child.highlightedContent = this.highlight(child.content);
                        }
                    }

                    if (this.searchResponse.jots) {
                        for (let child of this.searchResponse.jots) {
                            child.highlightedTitle = this.highlight(child.title);
                            child.highlightedContent = this.highlight(child.content);
                        }
                    }

                    if (this.searchResponse.jotConvo) {
                        for (let child of this.searchResponse.jotConvo) {
                            child.highlightedContent = this.highlight(child.content);
                        }
                    }

                    if (this.searchResponse.jargons) {
                        for (let child of this.searchResponse.jargons) {
                            child.highlightedTitle = this.highlight(child.title);
                            child.highlightedContent = this.highlight(child.content);
                        }
                    }

                }).catch(err => {
                    console.log(err);
                });

            },
            close() {
                this.$bvModal.hide("searchModal");
            },

            jotSelect(jot) {
                this.$router.replace({name: 'userJots', params: {id: jot.id}})
            },

            jotConvoSelect(jotConvo) {
                this.$router.replace({name: 'userJots', params: {id: jotConvo.jotID}})
            },

            jargonSelect(jargon) {
                this.$router.replace({name: 'jargonPage', params: {id: jargon.id}})
            },

            openTask() {

                if (this.$route.query.taskID) {
                    this.folders.forEach(folder => {
                        if (folder.type === 'task') {

                            if (folder.id == this.$route.query.taskID) {

                                this.task = folder;
                                if (this.task.sub_task.length > 0) {
                                    if(this.$route.query.subTaskID){
                                        this.task.sub_task.forEach((sub,index) => {
                                            if(sub.id == this.$route.query.subTaskID){
                                                this.currentSlide = index;
                                            }
                                        })

                                        this.currentSlide = 1;
                                    }
                                    this.subTaskCopy = JSON.parse(JSON.stringify(this.task.sub_task));
                                    let startSub = {
                                        title: "start!",
                                        taskTitle: this.task.title,
                                        content_html: this.task.content_html,
                                        image_url: this.task.image_url,
                                        media_type: this.task.media_type,
                                        searchType: this.task.searchType,
                                        id: this.task.id
                                    }
                                    this.subTaskCopy.unshift(startSub);
                                } else {
                                    this.subTaskCopy = [
                                        {
                                            taskTitle: this.task.title,
                                            id: this.task.id,
                                            searchType: this.task.searchType,
                                        }
                                    ];
                                }
                                this.$bvModal.show("modalID");

                            }
                        }
                    })

                }
            }
        },

        mounted() {


        },

        created() {

            let path = "";
            if (this.$route.params) {
                if (this.$route.params.pathMatch) {
                    path = this.$route.params.pathMatch;
                }
            }

            let trim = this.$route.path;
            let trimmed = trim.replace(/^\/|\/$/g, '');
            let split = trimmed.split("/");

            this.breadCrumbs = this.breadCrumbs.concat(split)

            let last = this.breadCrumbs.slice(-1)[0];

            if (last === 'folders' || !last) {
                axios.get('folders').then(response => {
                    this.folders = response.data.table;
                    this.openTask()
                }).catch(err => {
                    console.log(err);
                });
            } else {
                axios.get('folders/' + last).then(response => {
                    this.folders = response.data.table;
                    this.openTask()
                }).catch(err => {
                    console.log(err);
                });
            }
        }

    }

</script>

<style lang="scss">

    .search-button{
        font-size: 1.2rem
    }


    .search-list {
        list-style-type: none;

        li {
            div {
                display: inline-block;
            }
        }
    }

    .imageColumn {
        width: 130px;
    }

    .imageHeader {
        visibility: hidden;
    }

    .table-header {
        text-transform: lowercase
    }

    .folder-table {

        font-size: 22px;

        tr {
            cursor: pointer;
            outline: none;
        }

        td {
            cursor: pointer !important;
            outline: none;
        }

        table {
            thead {
                th {
                    border-top: 0;
                }
            }
        }
    }

    .breadcrumb-container {

        display: flex;
        flex-direction: row;
        justify-content: space-between;

        margin-bottom: 50px;


        .search-container {
            display: flex;
            align-items: center;

            .search-button {
                font-size: 22px;

            }
        }


        .breadcrumb-ul {
            display: flex;
            flex-wrap: wrap;
            -webkit-box-pack: start;
            justify-content: flex-start;
            /*margin: 30px 0;*/
            padding: 0;
            font-size: 22px;
            font-weight: 500;

            li {
                align-items: center;
                display: flex;

                span {
                    padding: 0.75em;
                    font-weight: 900;
                    cursor: pointer;
                }
            }

            li:first-child {
                padding-left: 0;

                span:first-child {
                    padding-left: 12px
                }
            }

            li + li:before {
                /*color: #b5b5b5;*/
                content: "\0002f";
            }
        }
    }

    .search-form-container {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        margin-bottom: 10px;

        .search-button-container {
            width: 105px;
        }
    }

    .highlightText {
        background: #5e869f;
        color: white;
    }

    .type-class {
        max-width: 60px;
    }

    .search-list-item{
        cursor: pointer;
    }

    .search-card-title{
        font-weight: 700;
    }

    .search-card-container{
        display:flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: flex-start;
        .card{
            margin-right: 10px;
        }
    }

    .tasks-container{
        margin-bottom: 10px;
    }

</style>
