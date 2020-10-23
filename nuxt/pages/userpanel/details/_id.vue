<template>
  <div class="wrapper-content">
    <div class="content-table">
      <ClientPanelTabs></ClientPanelTabs>
      <div class="details-panel">
        <div class="account-name"><b>Аккаунт:</b> {{ account.account_name }}</div>
        <h1 class="tariff_name">Тариф {{ account.latest_order.service.category.name }}</h1>

        <div class="flex">
          <div class="left">
            <div class="likes">{{ account.latest_order.service.likes }}</div>
            <div class="lakes_label">Лайков</div>
            <div class="likes_posts">На <b>{{ account.latest_order.service.posts }}</b> постов</div>

            <div class="views">{{ account.latest_order.service.views }}</div>
            <div class="views_label">Просмотров</div>

            <div class="igtv_label" v-if="account.latest_order.service.igtv_unlim">На видео и IGTV</div>
            <div class="igtv_label_unlim" v-if="account.latest_order.service.igtv_unlim">(<span>Безлимит</span><div class="fire"></div>)</div>
          </div>

          <div class="center">
            <div class="bonus" v-if="account.latest_order.service.bonus !== null">
              <div class="bonus__img"></div>
              <div class="bonus__title">Бонус</div>
              <div class="bonus__comments">{{ account.latest_order.service.bonus }}</div>
            </div>

            <div class="price__label">Стоимость</div>
            <div class="price">{{ account.latest_order.service.price_formatted }}</div>
            <div class="price__currency">руб./мес</div>
          </div>

          <div class="right">
            <client-only v-if="account.latest_order.expiration_ms > 0">
              <countdown :time="account.latest_order.expiration_ms" :interval="1000">
                <template slot-scope="props">
                  <div class="expires">
                    <div class="expires__label">{{ $plur(account.latest_order.days, ['Остался', 'Осталось', 'Осталось']) }}</div>
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
              <div class="expires__days_count">{{ account.latest_order.service.periodindays }}</div>
              <div class="expires__days">Дней</div>
            </div>

            <div v-if="account.latest_order.paid_status === 'active'" class="buttons">
              <a class="btn" href="#" @click.prevent="prolongOrder">Продлить</a>
              <nuxt-link class="btn" :to="{ path: '/userpanel/details/edit?account=' + account.id }">Изменить</nuxt-link>
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

    const data = await $axios.$get('/user/accounts', {
      params: {
        id: params.id
      }
    });

    return {
      account: data
    };
  },

  methods: {
    prolongOrder () {
      this.$modal.show(ActivateServiceModal, {
        service: this.account.latest_order.service,
        accountId: this.account.id
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
