<template>
  <div class="wrapper-content">
    <div class="content-table">
      <ClientPanelTabs></ClientPanelTabs>
      <div class="table-wrapper">
        <table v-if="orders.length">
          <thead>
          <tr>
            <th>Услуга</th>
            <th>Аккаунт</th>
            <th>Дата окончания</th>
            <th>Действия</th>
          </tr>
          </thead>
          <tbody>
          <tr :key="key" v-for="(order, key) in orders">
            <td data-label="Услуга">
              <div class="text-big">{{ order.service.category.name }}</div>
              <div class="text-large">{{ order.service.name }}</div>
            </td>
            <td data-label="Аккаунт">
              <div class="text-default">{{ order.account.account_name }}</div>
            </td>
            <td data-label="Дата окончания">
              <div class="text-big">{{ order.expiration_date_format }}</div>
              <div class="text-small">осталось {{ order.days }} дней</div>
            </td>
            <td data-label="Действия">
              <nuxt-link class="btn" :to="`/userpanel/details/${order.id}`">Детали</nuxt-link>
            </td>
          </tr>
          </tbody>
        </table>
        <div v-else class="no-orders">Заказов не найдено</div>
      </div>
    </div>
  </div>
</template>

<script>
import ClientPanelTabs from '@/components/ClientPanelTabs'

export default {
  name: 'UserPanel',
  layout: 'userpanel',
  middleware: 'auth',
  watchQuery: ['tab'],

  components: {
    ClientPanelTabs
  },

  async asyncData ({ params, query, error, $axios }) {
    const tab = query.tab || 'active';
    const data = await $axios.$get('/user/orders', {
      params: {
        tab: tab
      }
    });

    return {
      tab: tab,
      orders: data
    };
  },

  data () {
    return {
      tab: 'active'
    }
  },

  head() {
    return {
      title: 'Личный кабинет'
    }
  }
}
</script>
