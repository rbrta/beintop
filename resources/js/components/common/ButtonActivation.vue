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

                this.$modal.show(ModalActivation,{service: this.service},{width: 800, height: 'auto', adaptive: true, scrollable: true});   
            }
        }
    }
</script>

<style scoped>
</style>
