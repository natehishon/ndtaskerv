<template>

    <div class="container-fluid">
        <form enctype="multipart/form-data">
            <div class="row">
                <div class="col-xs-12">
                    <h1>Create a task!</h1>

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control"
                               v-model="newTask.title">
                    </div>

                    <div class="form-group">
                        <label>Content</label>
                        <ckeditor :editor="editor" v-model="newTask.content" :config="editorConfig"></ckeditor>
                    </div>

                    <div class="form-group">
                        <label>Task Image</label>
                        <input type="file" ref="file" @change="onSelect" />
                    </div>

                    <button class="btn btn-secondary btn-block" @click="check($event)">Save</button>
                </div>
            </div>
        </form>
    </div>


</template>

<script>

    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import axios from 'axios';
    // import EasyImage from '@ckeditor/ckeditor5-easy-image/src/easyimage';


    export default {
        data() {
            return {
                // file: "",
                newTask: {
                    title: "title",
                    // content: "",
                    content: '<p>Content of the editor.</p>',
                },
                file: "",
                editor: ClassicEditor,

                editorConfig: {
                    // plugins: [ EasyImage ]
                }
            }
        },
        methods: {

            onSelect(){
                const file = this.$refs.file.files[0];
                console.log(file);
                this.file = file;
            },

            check(event){

                event.preventDefault();

                const formData = new FormData();
                formData.append('image', this.file);
                for ( let property in this.newTask ) {
                    console.log(property);
                    console.log(this.newTask[property]);
                    formData.append(property, this.newTask[property]);
                }

                console.log(formData);

                axios.post('/tasks', formData).then(response => {
                    console.log(response)
                }).catch(err => {
                    console.log(err);
                });


            }
        }

    }

</script>