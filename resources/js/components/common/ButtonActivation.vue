<template>
<div>
    <a class="btn" href="#" @click.prevent="showModal">Активировать</a>
       
</div>
</template>

<script>
    import ModalActivation from "./../common/ModalActivation";
    export default {
        name: "ButtonActivation",
        props: ['service', 'user', 'app_url', 'shop_id'],
        data() {
            return {
                order_id: '',
            }
        },
        mounted() {


        },
        methods: {
            showModal() {
                this.$showModal(ModalActivation, {
                    service: this.service,
                    app_url: this.app_url,
                    shop_id: this.shop_id,
                });
            },
            activation() {
                  axios.post('add-new-order', { user_id: this.user.id, service_id: this.service.id }).then(response => {
                        this.order_id = "ID_" + response.data.order_id;
                        this.$nextTick(_ => this.$refs.payment_form.submit());
                  });
            }
        }
    }
</script>

<style scoped>
</style>
