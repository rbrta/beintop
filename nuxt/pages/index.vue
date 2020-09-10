<template>
  <main>
    <div class="container-top">
      <div class="wrapper-content promotion-wrapper">
        <div class="rocket">
        </div>

        <section class="promotion">
          <div class="promotion-title">
            Раскрутка вашего Instagram аккаунта
          </div>
          <div class="promotion-desc">
            Сервис по доходу комплексной и автоматической активности
          </div>
          <div class="promotion-btn">
            <a href="#tariffs">Выбрать тариф</a>
          </div>
        </section>
      </div>
      <!-- ------------------------------------------------------------------------------- -->
      <div class="wrapper-content">
        <section class="advantage">
          <div class="advantage-item" id="advantage">
            <div class="advantage-img">
              <img src="/images/phone.svg" alt="">
            </div>
            <div class="advantage-text">
              <div class="advantage-title">
                Что мы предоставляем клиентам?
              </div>
              <div class="advantage-hr">
              </div>
              <div class="advantage-desc tar">
                Комплексную и автоматическую раскрутку instagram аккаунтов, сформированную в пакетах, которая позволяет блогерам, рекламодателям, коммерческим аккаунтам и медийным личностям выходить во все ТОП-ы (лента, Топ лучших публикаций) и привлекать целевую аудиторию.
              </div>
            </div>
          </div>
          <div class="advantage-item">
            <div class="advantage-text">
              <div class="advantage-title">В чем удобства нашего cервиса для клиента?</div>
              <div class="advantage-hr">
              </div>
              <div class="advantage-desc tal">
                В автоматизации услуги и экономии времени! Приобретая тариф в нашем сервисе, вы получите автоматическую услугу, которая позволит сэкономить ваше личное время. Также за каждым клиентом у нас закрепляется личный персональный менеджер, с которым вы можете связаться 24/7
              </div>
            </div>
            <div class="advantage-img">
              <img src="/images/clock.svg" alt="">
            </div>
          </div>
        </section>
      </div>
      <div class="mobile-bottom-waves"></div>
    </div>

    <div id="app" class="container-middle">
      <div class="wrapper-content">
        <TariffsList :services="services"></TariffsList>
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
              Нажмите “Заказать” и перейдите к оплате
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
  name: 'HomePage',

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

  head() {
    return {
      title: 'Главная'
    }
  },
}
</script>
