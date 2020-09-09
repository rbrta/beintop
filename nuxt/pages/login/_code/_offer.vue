<template>
  <TariffsList title="Рекомендованный тариф" :services="services" :hide-categories="true" @buy="acceptOrder"></TariffsList>
</template>

<script>
import TariffsList from '@/components/TariffsList'
import AcceptManagerOfferModal from '@/components/modals/AcceptManagerOfferModal'

export default {
  name: "LoginCode",
  layout: 'userpanel',
  auth: 'guest',

  components: {
    TariffsList
  },

  async asyncData({ params, $auth, error, redirect, $axios }) {
    try {
      await $auth.loginWith('local', { data: { code: params.code } })

      return await $axios.$get('/user/accept-offer', {
        params: {
          offer_id: params.offer
        }
      });
    } catch (err) {
      console.error(err.response.data || err);
      error({ statusCode: err.response.status, message: err.response.statusText });
    }

    return {

    };
  },

  methods: {
    acceptOrder(tariff) {
      this.$modal.show(AcceptManagerOfferModal, {
        service: tariff,
        offer: this.offer
      })
    }
  },

  head() {
    return {
      title: 'Рекомендованный тариф'
    }
  }
}
</script>


<style scoped>

</style>
