<template>
    <span></span>
</template>
<script>
    import ModalActivation from "./ModalActivation.vue";
    export default {
        name: "BuyModalLoader",
        props: ['idservice'],
        data() {
            return {
                service: '',
            }
        },
        mounted() {
            if(this.idservice !== "") {
                axios.get(`/service_details/${this.idservice}`).then(response => {
                    this.service = response.data;

                    this.showModal();
                })
            }

        },
        methods: {
            showModal() {
                this.$showModal(ModalActivation, {
                    service: this.service,
                });
            },
            
        }
    }
</script>

<style scoped>
</style>
