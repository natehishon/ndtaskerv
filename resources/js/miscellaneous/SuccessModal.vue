<template>

    <div class="">

        <b-modal
            :id="'successModal'+uniqueId" size="md"
            title="success!"
            hide-footer
        >
            <div class="container-fluid text-center">
                <b-button size="lg" @click="dismiss" variant="success" class="large-button">
                    <i class="fas fa-check"></i> okay
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
