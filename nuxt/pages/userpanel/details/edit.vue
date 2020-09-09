<template>
  <TariffsList title="Выберите новый тариф" :services="services" @buy="changeTariff"></TariffsList>
</template>

<script>
import TariffsList from '@/components/TariffsList'
import ChangeAccountTariffModal from '@/components/modals/ChangeAccountTariffModal'

export default {
  name: "EditUserTariff",
  layout: 'userpanel',
  middleware: 'auth',

  components: {
    TariffsList
  },

  async asyncData({ $axios, query, error }) {
    if(!query.account) error(404);

    const data = await $axios.$get('/services');
    return {
      services: data,
    };
  },

  methods: {
    async changeTariff (service) {
      try {
        const data = await this.$axios.$get('/user/accounts/change-tariff', {
          params: {
            account_id: this.$route.query.account,
            service_id: service.id
          }
        });

        this.$modal.show(ChangeAccountTariffModal, {
          service: service,
          accountId: this.$route.query.account,
          price: data.price
        })
      } catch (e) {
        console.error(e);
      }
    }
  },

  head() {
    return {
      title: 'Изменить тариф'
    }
  }
}
</script>

<style scoped>

</style>
