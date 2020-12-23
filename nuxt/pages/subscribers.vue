<template>
  <main>
    <div class="container-middle">
      <div class="wrapper-content">
        <TariffsList :services="services" :categories="categories"></TariffsList>
      </div>

    </div>

    <div class="container-below">
      <div class="row1">
        <span>Как это работает?</span>
      </div>
      <div class="row2">
        <div class="content">
          <div class="col col1">
            <div class="col__title"><img src="/images/digital.svg" alt=""></div>
            <div class="col__desc">Выберите тариф</div>
          </div>
          <div class="col arrow col2">
            <!-- <img src="./assets/images/arrow.svg" alt=""> -->
          </div>
          <div class="col col3">
            <div class="col__title"><img src="/images/pay-card.svg" alt=""></div>
            <div class="col__desc">
              Нажмите «Заказать», чтобы узнать подробную информацию
            </div>
          </div>
          <div class="col arrow col4">
            <!-- <img src="./assets/images/arrow.svg" alt=""> -->
          </div>
          <div class="col col5">
            <div class="col__title"><img src="/images/love.svg" alt=""></div>
            <div class="col__desc">
              Убедитесь в качестве работы и наслаждайтесь результатом
            </div>
          </div>
          <div>
          </div>
        </div>
        <div class="row3" id="choosetariff">
          <a class="scrollTo" href="#tariffs">Выбрать тариф</a>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import TariffsList from '@/components/TariffsList'

export default {
  layout: 'homepage',
  name: 'SubscribersPage',

  components: {
    TariffsList
  },

  async asyncData({ $axios, error }) {
    try {
      const data = await $axios.$get('/services/subscribers');
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

  data() {
    return {
      services: [],
      categories: [],
    }
  },

  head() {
    return {
      title: 'Подписчики',
    }
  },
}
</script>

<style scoped>
.container-middle {
  margin-top: 0;
  padding-top: 2rem;
}
</style>