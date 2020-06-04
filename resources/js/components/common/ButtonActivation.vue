<template>
<div>
    <a class="btn" href="#" @click.prevent="activation">Активировать</a>
       <div v-show="false">
        <form ref="payment_form" name="payment" method="post" action="https://sci.interkassa.com/" accept-charset="UTF-8">
            <input type="hidden" name="ik_co_id" value="5ed3d7051ae1bd39008b457b"/>
            <input type="hidden" name="ik_pm_no" :value="order_id"/>
            <input type="hidden" name="ik_am" :value="service.price"/>
            <input type="hidden" name="ik_cur" value="RUB"/>
            <input type="hidden" name="ik_desc" :value="description"/>

            <input type="hidden" name="ik_ia_u" value="https://beintop.kwonterdevs.pp.ua/payment/callback"/>
            <input type="hidden" name="ik_suc_u" value="https://beintop.kwonterdevs.pp.ua/payment/success"/>
            <input type="hidden" name="ik_fal_u" value="https://beintop.kwonterdevs.pp.ua/payment/failure"/>
            <input type="hidden" name="ik_pnd_u" value="https://beintop.kwonterdevs.pp.ua/payment/pending"/>

            <input type="submit" value="Pay">
        </form>
    </div>
</div>
</template>

<script>
    import ModalActivation from "./../common/ModalActivation";
    export default {
        name: "ButtonActivation",
        props: ['service', 'user'],
        data() {
            return {
                order_id: '',
            }
        },
        mounted() {
            this.service = JSON.parse(this.service);
            this.user = JSON.parse(this.user);
        },
        methods: {
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
