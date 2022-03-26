<template>
  <section id="tariffs" class="tariffcontainer">
    <div class="tariffcontainer-title">
      Рекомендованный тариф
    </div>
    <div class="tariff-category">
      <div class="tarif-category-body">
        <TariffsListItem v-for="service in services" :key="service.id" :service="service" @buy="acceptOrder"></TariffsListItem>
      </div>
    </div>
  </section>
</template>

<script>
import AcceptManagerOfferModal from '@/components/modals/AcceptManagerOfferModal'
import TariffsListItem from "~/components/TariffsListItem";

export default {
  name: "LoginCode",
  layout: 'userpanel',
  auth: 'guest',

  components: {
    TariffsListItem
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
    acceptOrder(service) {
      this.$modal.show(AcceptManagerOfferModal, {
        service: service,
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

<style lang="scss">
@import "assets/sass/tariffs";
</style>
