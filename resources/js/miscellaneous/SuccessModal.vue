<template>

    <div class="">

        <b-modal
            :id="'successModal'+uniqueId" size="md"
            title="success"
            hide-footer
        >
            <div class="container-fluid">
                <b-button size="lg" @click="dismiss" variant="success">
                    <i class="fas fa-plus "></i> save
                </b-button>
            </div>

        </b-modal>

    </div>
</template>

<style>


</style>

<script>


    export default {
        name: 'adminTools',
        data() {
            return {

            }
        },
        props: ['uniqueId'],
        components: {},
        methods: {
            dismiss() {
                this.$bvModal.hide("successModal"+this.uniqueId);
            },
            show(){
                this.$bvModal.show("successModal"+this.uniqueId);
            }
        },
    }

</script>
