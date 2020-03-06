<template>


    <div  style="display:inline-block">

        <b-button :id="time" size="sm" variant="info">
            <div class="slot-wrapper">
                <slot></slot>
            </div>
        </b-button>
        <b-popover :target="time" triggers="hover blur click" placement="top" :title="jargon.title">
<!--            <template v-slot:title>Popover Title</template>-->
            {{jargon.content}} <br>
            <a href="https://www.w3schools.com/html/">Visit our HTML tutorial</a>
        </b-popover>

        <!--                <b-button :id="`popover-${jargon.id}`" size="sm" :variant="jargon.color" @click="closePop(jargon.id)" triggers="">-->
        <!--                    <div class="slot-wrapper">-->
        <!--                        <slot></slot>-->
        <!--                    </div>-->
        <!--                </b-button>-->
        <!--                <b-popover-->
        <!--                        :target="`popover-${jargon.id}`"-->
        <!--                        :title="jargon.title"-->
        <!--                        placement="top">-->
        <!--                    <template>Popover Title</template><br>-->
        <!--                    {{jargon.content}}-->
        <!--                    <br>-->
        <!--    &lt;!&ndash;                <p>Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero's De Finibus Bonorum et Malorum for use in a type specimen book.</p>&ndash;&gt;-->
        <!--                    <a href="https://www.w3schools.com/html/">Visit our HTML tutorial</a>-->
        <!--                </b-popover>-->

    </div>
    <!--    <b-button size="sm" variant="success" v-b-popover.hover.click.blur.top="jargon.content"-->
    <!--              :title="jargon.title">-->
    <!--        <div class="slot-wrapper">-->
    <!--            <slot></slot>-->
    <!--        </div>-->

    <!--    </b-button>-->


</template>

<script>

    export default {

        data() {
            return {
                searchTag: "",
                jargon: {
                    title: "yo",
                    content: "yo yo"
                },
                time: null
            }
        },
        mounted() {

            this.searchTag = this.$el.getElementsByClassName("slot-wrapper")[0].innerHTML;
            console.log("I am calling for " + this.searchTag)
            const request = axios.get("jargons/" + this.searchTag).then(response => {
                console.log(response.data);
                this.jargon = response.data.data;
                this.loading = false;
            })

        },
        created() {
            let d = new Date();
            this.time = d.getTime().toString();
        },
        methods: {
            closePop(id) {
                this.$root.$emit('bv::hide::popover', 'popover-' + id)
            }
        }
    }

</script>