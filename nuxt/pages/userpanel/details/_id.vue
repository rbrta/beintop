<template>
  <div class="wrapper-content">
    <div class="content-table">
      <ClientPanelTabs></ClientPanelTabs>
      <div class="details-panel">
        <div class="account-name"><b>Аккаунт:</b> {{ order.account.account_name }}</div>
        <h1 class="tariff_name">Тариф {{ order.service.category.name }}</h1>

        <div class="flex">
          <div class="left">
            <template v-if="order.service.parameters.subscribers">
              <div class="likes">{{ order.service.parameters.subscribers }}</div>
              <div class="lakes_label">Подписчиков</div>
            </template>
            <template v-if="order.service.parameters.likes">
              <div class="likes">{{ order.service.parameters.likes }}</div>
              <div class="lakes_label">Лайков</div>
            </template>
            <template v-if="order.service.parameters.posts">
              <div class="likes_posts">На <b>{{ order.service.parameters.posts }}</b> постов</div>
            </template>
            <template v-if="order.service.parameters.views">
              <div class="views">{{ order.service.parameters.views }}</div>
              <div class="views_label">Просмотров</div>
            </template>
            <template v-if="order.service.parameters.igtv_unlim && order.service.parameters.igtv_unlim === '1'">
              <div class="igtv_label">На видео и IGTV</div>
              <div class="igtv_label_unlim">(<span>Безлимит</span><div class="fire"></div>)</div>
            </template>
          </div>

          <div class="center">
            <div class="bonus" v-if="order.service.parameters.bonus">
              <div class="bonus__img"></div>
              <div class="bonus__title">Бонус</div>
              <div class="bonus__comments">{{ order.service.parameters.bonus }}</div>
            </div>

            <div class="price__label">Стоимость</div>
            <div class="price">{{ order.service.price_formatted }}</div>
            <div class="price__currency">{{ order.service.periodindays ? 'руб./мес' : 'руб.' }}</div>
          </div>

          <div class="right" v-if="order.expiration_date">
            <client-only v-if="order.expiration_ms > 0">
              <countdown :time="order.expiration_ms" :interval="1000">
                <template slot-scope="props">
                  <div class="expires">
                    <div class="expires__label">{{ $plur(order.days, ['Остался', 'Осталось', 'Осталось']) }}</div>
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
            </client-only>

            <div v-else class="expires">
              <div class="expires__label">Период</div>
              <div class="expires__days_count">{{ order.service.periodindays }}</div>
              <div class="expires__days">Дней</div>
            </div>

            <div v-if="order.paid_status === 'active'" class="buttons">
              <a class="btn" href="#" @click.prevent="prolongOrder">Продлить</a>
              <nuxt-link class="btn" :to="{ path: '/userpanel/details/edit?order=' + order.id }">Изменить</nuxt-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ClientPanelTabs from '@/components/ClientPanelTabs'
import ActivateServiceModal from '@/components/modals/ActivateServiceModal'

export default {
  name: "ClientOrderDetails",
  layout: 'userpanel',
  middleware: 'authorized',

  components: {
    ClientPanelTabs
  },

  async asyncData ({ params, query, error, $axios }) {
    if(!params.id) error(404);

    const data = await $axios.$get(`/user/orders/${params.id}`);

    return {
      order: data
    };
  },

  methods: {
    prolongOrder () {
      this.$modal.show(ActivateServiceModal, {
        service: this.order.service,
        category: this.order.service.category,
        order: this.order
      })
    }
  },

  head() {
    return {
      title: 'Детали аккаунта'
    }
  }
}
</script>

<style scoped>
.btn {
  min-width: 125px;
  font-size: 16px;
}
</style>
