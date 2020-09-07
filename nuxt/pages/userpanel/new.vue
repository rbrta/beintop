<template>
  <div>
    <TariffsList :services="services" @buy="buyTariff"></TariffsList>
  </div>
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
    buyTariff (service) {
      this.$modal.show(ActivateServiceModal, {
        service
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
