<template>

    <div>

        <h6 class="text-uppercase text-secondary font-weight-bolder">Check Availability</h6>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="from">From</label>
                <input
                    type="text"
                    name="from"
                    class="form-control form-control-sm"
                    placeholder="Start date"
                    v-model="from"
                    @keyup.enter="check"
                >
            </div>

            <div class="form-group col-md-6">
                <label for="to">To</label>
                <input
                        type="text"
                        name="to"
                        class="form-control form-control-sm"
                        placeholder="To date"
                        v-model="to"
                        @keyup.enter="check"
                >
            </div>
        </div>

        <button class="btn btn-secondary btn-block" @click="check">Check!</button>
<!--        <va-button-->
<!--                name="Primary"-->
<!--                theme="primary"-->
<!--                size="btn-lg"-->
<!--                :isFlat="true"-->
<!--        ></va-button>-->
    </div>

</template>

<script>
    import VAButton from 'vue2-admin-lte/src/components/VAButton.vue'
    export default {
        data() {
            return {
                from: null,
                to: null
            };
        },
        methods: {
            check(){
                console.log("yo");
            }
        },
        components:{
            'va-button': VAButton
        }
    }

</script>