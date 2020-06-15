<template>
    <div></div>
</template>

<script>
    export default {
        name: "ScrollToComponent",
        components: {
            scrollto: require('vue-scrollto')
        },
        data() {
            return {
                scrollTo: '',
            }
        },
        mounted() {

            window.addEventListener('scrollToEvent', (e)=>{
                this.scroll(e.detail.el);
            }, false);


        },
        methods: {
            scroll(element){
                this.$scrollTo(element, {
                    duration: 500,
                    easing: "ease",
                });
            }
        }
    }
</script>

<style scoped>
</style>
