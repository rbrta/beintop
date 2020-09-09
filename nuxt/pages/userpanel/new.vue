<template>
  <TariffsList :services="services" @buy="buyTariff"></TariffsList>
</template>

<script>
import TariffsList from '@/components/TariffsList'
import ActivateServiceModal from '@/components/modals/ActivateServiceModal'

export default {
  name: "ClientNewOrder",
  layout: 'userpanel',
  middleware: 'auth',

  components: {
    TariffsList
  },

  async asyncData({ $axios }) {
    const data = await $axios.$get('/services');
    return {
      services: data,
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
