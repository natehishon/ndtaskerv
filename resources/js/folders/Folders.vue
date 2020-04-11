<template>

    <div>

        <b-table hover :items="folders" :fields="fields"></b-table>

    </div>

</template>

<script>

    import axios from 'axios';

    export default {

        props: ['name'],

        data() {
            return {
                folders: null,
                fields: ['name']
            }
        },

        created() {
            // this.loading = true;
            let path = "";
            if(this.$route.params){
                if (this.$route.params.pathMatch){
                    path = this.$route.params.pathMatch;
                    // path = slash.replace(/[^0-9a-z]/gi, '')
                }
            }
            console.log(this.$route)

            axios.get('/folders' + path).then(response => {

                console.log(response.data.data);
                this.folders = response.data.data;


            }).catch(err => {
                console.log(err);
            });
        }

    }

</script>