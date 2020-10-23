<template>
  <div class="wrapper-content">
    <div class="content-table">
      <ClientPanelTabs></ClientPanelTabs>
      <div class="table-wrapper">
        <table v-if="accounts.length">
          <thead>
          <tr>
            <th>Аккаунт</th>
            <th>Услуга</th>
            <th>Дата окончания</th>
            <th>Действия</th>
          </tr>
          </thead>
          <tbody>
          <tr :key="key" v-for="(account, key) in accounts">
            <td data-label="Аккаунт">
              <div class="text-default">{{ account.account_name }}</div>
            </td>
            <td data-label="Услуга">
              <template v-if="account.latest_order">
                <div class="text-big">{{ account.latest_order.service.category.name }}</div>
                <div class="text-large">{{ account.latest_order.service.name }}</div>
              </template>
            </td>
            <td data-label="Дата окончания">
              <template v-if="account.latest_order && account.latest_order.paid_status === 'active'">
                <div class="text-big">{{ account.latest_order.expiration_date_format }}</div>
                <div class="text-small">осталось {{ account.latest_order.days }} дней</div>
              </template>
              <template v-else>
                <span>-</span>
              </template>
            </td>
            <td data-label="Действия">
              <template v-if="account.latest_order">
                <a v-if="account.latest_order.is_expired" href="#" class="btn" @click.prevent="prolongOrder(account)">Продлить</a>
                <nuxt-link v-else class="btn" :to="`/userpanel/details/${account.id}`">Детали</nuxt-link>
              </template>
              <nuxt-link v-else class="btn" :to="{ path: '/userpanel/new?account=' + account.id }">Выбрать тариф</nuxt-link>
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

  async asyncData ({ params, query, error, $axios }) {
    try {
      const data = await $axios.$get('/user/accounts');

      return {
        accounts: data
      };
    } catch (err) {
      console.error(err.response.data || err);
      error({ statusCode: err.response.status, message: err.response.statusText });
    }

    return false;
  },

  methods: {
    prolongOrder(account) {
      this.$modal.show(ActivateServiceModal, {
        service: account.latest_order.service,
        accountId: account.id
      })
    }
  },

  head() {
    return {
      title: 'Личный кабинет'
    }
  }
}
</script>

<style scoped>
.no-orders {
  text-align: center;
  padding: 15px 0;
}
</style>
