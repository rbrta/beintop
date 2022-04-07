<template>
  <div>
    <TariffsList
      ref="tariffs"
      :services="services"
      :categories="categories"
      :socials="socials"
      @buy="buyTariff"
    ></TariffsList>
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
      const data = await $axios.$get('/services/');
      return {
        ...data
      };
    } catch (err) {
      console.error(err.response.data || err);
      error({ statusCode: err.response.status, message: err.response.statusText });
    }

    return {
      services: [],
      categories: [],
      socials: []
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
    async buyTariff(service) {

      if (this.$route.query.account) {
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
        this.$nextTick(() => this.$refs.tariffs.setCurrentCategory());
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
  color: #5c4998;
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
      background: linear-gradient(
        180deg,
        #b04e98 18.23%,
        #873e90 90.1%,
        #73307b 100%
      );
      color: white;
    }
  }
}
</style>
