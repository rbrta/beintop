<template>
  <main>
    <div id="app" class="container-middle">
      <rocket-svg />
      <clock-svg />
      <phone-svg />
      <div class="wrapper-content">
        <TariffsList :services="services" :categories="categories" :socials="socials"></TariffsList>
      </div>
    </div>
  </main>
</template>

<script>
import TariffsList from '@/components/TariffsList'
import RocketSvg from '~/components/design/RocketSvg.vue';
import ClockSvg from '../components/design/ClockSvg.vue';
import PhoneSvg from '../components/design/PhoneSvg.vue';

export default {
  layout: 'homepage',
  name: 'HomePage',

  components: {
    TariffsList,
    RocketSvg,
    ClockSvg,
    PhoneSvg
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
      socials: []
    }
  },

  head() {
    return {
      title: 'Главная',
    }
  },
}
</script>
