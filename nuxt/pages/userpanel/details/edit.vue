<template>
  <TariffsList title="Выберите новый тариф" :services="services" :categories="categories" @buy="changeTariff"></TariffsList>
</template>

<script>
import TariffsList from '@/components/TariffsList'
import ChangeAccountTariffModal from '@/components/modals/ChangeAccountTariffModal'

export default {
  name: "EditUserTariff",
  layout: 'userpanel',
  middleware: 'authorized',

  components: {
    TariffsList
  },

  async asyncData({ $axios, query, error }) {
    if(!query.order) error(404);

    const data = await $axios.$get('/services/likes');
    return {
      services: data.services,
      categories: data.categories,
    };
  },

  methods: {
    async changeTariff (service) {
      try {
        const data = await this.$axios.$get('/user/accounts/change-tariff', {
          params: {
            order_id: this.$route.query.order,
            service_id: service.id
          }
        });

        const category = this.categories.find(category => category.id === service.category_id);

        this.$modal.show(ChangeAccountTariffModal, {
          service: service,
          category: category,
          orderId: this.$route.query.order,
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
