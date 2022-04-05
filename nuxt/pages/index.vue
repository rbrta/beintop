<template>
  <main>
    <div id="app" class="container-middle">
      <div class="wrapper-content">
        <TariffsList :services="services" :categories="categories"></TariffsList>
      </div>
    </div>
  </main>
</template>

<script>
import TariffsList from '@/components/TariffsList'

export default {
  layout: 'homepage',
  name: 'HomePage',

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
    };
  },

  data() {
    return {
      services: [],
      categories: [],
    }
  },

  head() {
    return {
      title: 'Главная',
    }
  },
}
</script>
