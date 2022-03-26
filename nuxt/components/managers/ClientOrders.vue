<template>
  <div class="content-table">
    <div class="table-wrapper" v-if="client.orders.length">
      <table>
        <caption>Заказы клиента: {{ client.full_name }}</caption>
        <thead>
        <tr class="table-title">
          <th>Аккаунт</th>
          <th>Услуга</th>
          <th>Дата оплаты</th>
          <th>Дата завершения</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="order in client.orders">
          <td>
            {{ order.account.account_name }}
          </td>
          <td>
            <template v-if="order.service">
              {{ order.service.category.name }} {{ order.service.name }}
            </template>
          </td>
          <td>
            {{ order.created_at_format }}
          </td>
          <td>
            {{ order.expiration_date_format }}
          </td>
        </tr>
        </tbody>
      </table>
    </div>
    <div v-else class="table-wrapper" style="text-align: center; padding: 30px 0">
      <div>У клиента пока нет заказов</div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ClientOrders",
  props: ['client']
}
</script>

<style scoped>
.content-table {
  margin: 0;
}

.content-table .table-wrapper {
  box-shadow: none;
}
</style>