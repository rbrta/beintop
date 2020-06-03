<template>
    <a @click.prevent="activation" class="btn" href="#">Детали</a>
</template>

<script>
    import ModalDetails from "./../common/ModalDetails";
    export default {
        name: "ButtonActivation",
        props: ['service'],
        methods: {
            activation() {
                this.$modal.show(ModalDetails, {service: this.service},{width: 1110, height: 'auto', adaptive: true, scrollable: true});   
            }
        }
    }
</script>

<style scoped>
</style>
