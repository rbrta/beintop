<template>
    <a href="#" @click.prevent="activation">Активировать</a>
</template>

<script>
    import ModalActivation from "./../common/ModalActivation";
    export default {
        name: "ButtonActivation",
        props: ['service'],
        methods: {
            activation() {

                this.$showModal(ModalActivation, {service: this.service}, 850);    
            }
        }
    }
</script>

<style scoped>
</style>
