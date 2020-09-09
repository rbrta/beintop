<template>
  <div class="wrapper-content admin">
    <div class="content-table">
      <div class="table-wrapper">
        <div class="flex j-end">
          <div @click="addClient" class="btn">Добавить клиента</div>
        </div>
        <table>
          <caption>Клиенты</caption>
          <thead>
          <tr class="table-title">
            <th>Аккаунт</th>
            <th>Тариф</th>
            <th>Дата оплаты</th>
            <th>Дата окончания</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item, index) in clients" :key="index + item.name">
            <td data-label="Аккаунт">{{ item.account_name }}</td>
            <td data-label="Тариф">
              <template v-if="item.latest_order">
                {{ item.latest_order.service.category.name }} {{ item.latest_order.service.name }}
              </template>
            </td>
            <td data-label="Дата оплаты">
              <template v-if="item.latest_order">
                {{ item.latest_order.created_at }}
              </template>
            </td>
            <td data-label="Дата окончания">
              <template v-if="item.latest_order">
                {{ item.latest_order.expiration_date_format }}
              </template>
            </td>
            <td data-label="Actions" class="table-action">
              <a class="btn" href="#" title="Копировать ссылку в буфер обмена"><i class="far fa-chart-bar"></i> Детали</a>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>

import AddClientModal from '~/components/modals/manager/AddClientModal'

export default {
  layout: 'panel',
  name: 'ManagerClients',
  middleware: 'manager',

  async asyncData({
    env,
    $axios,
    error
  }) {
    try {
      const data = await $axios.$get('/manager/clients');
      return {
        clients: data,
      };
    } catch (err) {
      console.error(err.response.data || err);
      error({ statusCode: err.response.status, message: err.response.statusText });
    }

    return {
      clients: [],
    }
  },


  methods: {
    addClient(service) {
      this.$modal.show(AddClientModal)
    }
  },


  head() {
    return {
      title: 'Управление клиентами'
    }
  },
}
</script>

<style scoped>
</style>
