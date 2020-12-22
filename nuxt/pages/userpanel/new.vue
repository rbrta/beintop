<template>
  <div>
    <h1 class="title">Выберите Услугу</h1>
    <div class="text-center services-type">
      <button :class="{ active : servicesType === 'likes' }" @click="servicesType = 'likes'">Активность</button>
      <button :class="{ active : servicesType === 'subscribers' }" @click="servicesType = 'subscribers'">Подписчики</button>
    </div>
    <TariffsList :services="services" :categories="categories" @buy="buyTariff"></TariffsList>
  </div>
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
      const data = await $axios.$get('/services/likes');
      return {
        services: data.services,
        categories: data.categories,
      };
    } catch (err) {
      console.error(err.response.data || err);
      error({ statusCode: err.response.status, message: err.response.statusText });
    }

    return {
      services: [],
      categories: [],
    };
  },

  created() {
    this.$store.dispatch('getOrders');
  },

  data() {
    return {
      services: [],
      categories: [],
      servicesType: 'likes',
    }
  },

  methods: {
    async buyTariff (service) {

      if(this.$route.query.account) {
        const data = await this.$axios.$get('/user/accounts', {
          params: {
            id: this.$route.query.account
          }
        });
      }

      const category = this.categories.find(category => category.id === service.category_id);

      this.$modal.show(ActivateServiceModal, {
        service: service,
        category: category
      })
    },

    async getServices() {
      try {
        const data = await this.$axios.$get(`/services/${this.servicesType}`);
        this.services = data.services;
      } catch (err) {
        console.error(err);
      }
    }
  },

  watch: {
    servicesType() {
      this.getServices();
    }
  },

  head() {
    return {
      title: 'Новый заказ'
    }
  }
}
</script>

<style lang="scss" scoped>
.title {
  font-weight: bold;
  font-size: 3.3rem;
  line-height: 1.5;
  text-align: center;
  color: #5C4998;
}

.services-type {
  margin-top: 2rem;
  margin-bottom: 40px;

  button {
    background: white;
    color: #bb56a1;
    width: 400px;
    height: 70px;
    border-radius: 40px;
    font-weight: 800;
    font-size: 1.4rem;
    text-transform: uppercase;
    margin: 0 10px;
    border: 5px solid #bb56a1;
    outline: none;
    cursor: pointer;

    &.active {
      background: linear-gradient(180deg, #B04E98 18.23%, #873E90 90.1%, #73307B 100%);
      color: white;
    }
  }
}
</style>