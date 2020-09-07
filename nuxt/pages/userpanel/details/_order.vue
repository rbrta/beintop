<template>
  <div class="wrapper-content">
    <div class="content-table">
      <ClientPanelTabs></ClientPanelTabs>
      <div class="details-panel">
        <h1 class="tariff_name">Тариф {{ order.service.category.name }}</h1>

        <div class="flex">
          <div class="left">
            <div class="likes">{{ order.service.likes }}</div>
            <div class="lakes_label">Лайков</div>
            <div class="likes_posts">На <b>{{ order.service.posts }}</b> постов</div>

            <div class="views">{{ order.service.views }}</div>
            <div class="views_label">Просмотров</div>

            <div class="igtv_label" v-if="order.service.igtv_unlim">На видео и IGTV</div>
            <div class="igtv_label_unlim" v-if="order.service.igtv_unlim">(<span>Безлимит</span><div class="fire"></div>)</div>
          </div>

          <div class="center">
            <div class="bonus" v-if="order.service.bonus !== null">
              <div class="bonus__img"></div>
              <div class="bonus__title">Бонус</div>
              <div class="bonus__comments">{{ order.service.bonus }}</div>
            </div>

            <div class="price__label">Стоимость</div>
            <div class="price">{{ order.service.price_formatted }}</div>
            <div class="price__currency">руб./мес</div>
          </div>

          <div class="right">
            <countdown :time="countdownTo" :interval="1000" v-if="order.expiration_date">
              <template slot-scope="props">
                <div class="expires">
                  <div class="expires__label">Осталось</div>
                  <div class="expires__days_count">{{ props.days }}</div>
                  <div class="expires__days">{{ $plur(props.days, $plurString.days)}}</div>

                  <div class="expires__timer">
                    <div class="value">{{ props.hours }} <span>{{ $plur(props.hours, $plurString.hours) }} </span></div>
                    <div class="delimeter">:</div>
                    <div class="value">{{ props.minutes }} <span>{{ $plur(props.minutes, $plurString.minutes) }}</span></div>
                    <div class="delimeter">:</div>
                    <div class="value">{{ props.seconds }} <span>{{ $plur(props.seconds, $plurString.seconds) }}</span></div>
                  </div>
                </div>
              </template>
            </countdown>
            <div v-else class="expires">
              <div class="expires__label">Период</div>
              <div class="expires__days_count">{{ order.service.periodindays }}</div>
              <div class="expires__days">Дней</div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ClientPanelTabs from '@/components/ClientPanelTabs'

export default {
  name: "ClientOrderDetails",
  layout: 'userpanel',
  middleware: 'auth',

  components: {
    ClientPanelTabs
  },

  async asyncData ({ params, query, error, $axios }) {
    if(!params.order) error(404);

    const data = await $axios.$get('/user/orders', {
      params: {
        id: params.order
      }
    });

    return {
      order: data
    };
  },

  computed: {
    countdownTo() {
      let expDate = new Date(this.order.expiration_date).getTime();
      let nowDate = new Date().getTime();

      return Math.abs(nowDate - expDate)
    }
  },

  head() {
    return {
      title: 'Детали заказа'
    }
  }
}
</script>
