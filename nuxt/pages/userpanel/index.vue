<template>
  <div class="wrapper-content">
    <div class="content-table">
      <ClientPanelTabs></ClientPanelTabs>
      <div class="table-wrapper">
        <table v-if="orders.length">
          <thead>
          <tr>
            <th>Аккаунт</th>
            <th>Услуга</th>
            <th>Дата окончания</th>
            <th>Действия</th>
          </tr>
          </thead>
          <tbody>
          <tr :key="key" v-for="(order, key) in orders">
            <td data-label="Аккаунт">
              <div class="text-default">{{ order.account.account_name }}</div>
            </td>
            <td data-label="Услуга">
              <template v-if="order.service">
                <div class="text-big">{{ order.service.category.name }}</div>
                <div class="text-large">{{ order.service.name }}</div>
              </template>
            </td>
            <td data-label="Дата окончания">
              <template v-if="order.service && order.service.type !== 'subscribers'">
                <div class="text-big">{{ order.expiration_date_format }}</div>
                <div class="text-small" v-if="order.is_expired">закончился {{ order.days }} {{ $plur(order.days, $plurString.days) }} назад</div>
                <div class="text-small" v-else>{{ $plur(order.days, ['остался', 'осталось', 'осталось']) }} {{ order.days }} {{ $plur(order.days, $plurString.days) }}</div>
              </template>
              <template v-else>
                <span>-</span>
              </template>
            </td>
            <td data-label="Действия">
              <template v-if="order.service">
                <a v-if="order.service.periodindays && order.is_expired" href="#" class="btn" @click.prevent="prolongOrder(order)">Продлить</a>
                <nuxt-link v-else class="btn" :to="`/userpanel/details/${order.id}`">Детали</nuxt-link>
              </template>
              <!--<nuxt-link v-else class="btn" :to="{ path: '/userpanel/new?account=' + account.id }">Выбрать тариф</nuxt-link>-->
            </td>
          </tr>
          </tbody>
        </table>
        <div v-else class="no-orders">
          <div style="margin-bottom: 10px">Нет добавленных аккаунтов</div>
          <nuxt-link class="btn" :to="{ path: '/userpanel/new' }">Добавить</nuxt-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ClientPanelTabs from '@/components/ClientPanelTabs'
import ActivateServiceModal from '~/components/modals/ActivateServiceModal'

export default {
  name: 'UserPanel',
  layout: 'userpanel',
  middleware: ['authorized', 'user'],

  components: {
    ClientPanelTabs
  },

  async asyncData ({ store }) {
    await store.dispatch('getOrders')
  },

  methods: {
    prolongOrder(order) {
      this.$modal.show(ActivateServiceModal, {
        service: order.service,
        category: order.service.category,
        order: order
      })
    }
  },

  computed: {
    orders() {
      return this.$store.state.orders;
    }
  },

  head() {
    return {
      title: 'Личный кабинет'
    }
  },
}
</script>

<style scoped>
.no-orders {
  text-align: center;
  padding: 15px 0;
}
</style>
