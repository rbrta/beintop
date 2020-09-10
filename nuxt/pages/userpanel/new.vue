<template>
  <TariffsList :services="services" @buy="buyTariff"></TariffsList>
</template>

<script>
import TariffsList from '@/components/TariffsList'
import ActivateServiceModal from '@/components/modals/ActivateServiceModal'

export default {
  name: "ClientNewOrder",
  layout: 'userpanel',
  middleware: 'authorized',

  components: {
    TariffsList
  },

  async asyncData({ $axios, error }) {
    try {
      const data = await $axios.$get('/services');
      return {
        services: data,
      };
    } catch (err) {
      console.error(err.response.data || err);
      error({ statusCode: err.response.status, message: err.response.statusText });
    }

    return {
      services: [],
    };
  },

  methods: {
    async buyTariff (service) {
      let isFirstOrder = false;

      if(this.$route.query.account) {
        const data = await this.$axios.$get('/user/accounts', {
          params: {
            id: this.$route.query.account
          }
        });

        isFirstOrder = data.latest_order === null;
      }

      this.$modal.show(ActivateServiceModal, {
        service: service,
        accountId: this.$route.query.account || null,
        isFirstOrder
      })
    },
  },

  head() {
    return {
      title: 'Новый заказ'
    }
  }
}
</script>
