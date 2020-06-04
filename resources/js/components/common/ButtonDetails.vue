<template>
    <a @click.prevent="activation" class="btn" href="#">Детали</a>
</template>

<script>
    import ModalDetails from "./../common/ModalDetails";
    export default {
        name: "ButtonActivation",
        props: ['order'],
        methods: {
            activation() {
                this.$modal.show(ModalDetails, {order: this.order},{width: 1110, height: 'auto', adaptive: true, scrollable: true});   
            }
        },
        mounted() {
            this.order= JSON.parse(this.order);
        }
    }
</script>

<style scoped>
</style>
