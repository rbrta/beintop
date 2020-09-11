<template>
  <div class="popup">
    <div class="table-wrapper">
      <table>
        <caption>Клиенты менеджера</caption>
        <thead>
        <tr class="table-title">
          <th>Имя</th>
          <th>Email</th>
          <th>Дата регистрации</th>
          <th>Услуги</th>
        </tr>
        </thead>
        <tbody v-if="clients.length > 0">
        <tr v-for="(item, index) in clients" :key="index">
          <td data-label="Имя">{{ item.full_name }}</td>
          <td data-label="Email">{{ item.email }}</td>
          <td data-label="Дата регистрации">{{ item.created_at }}</td>
          <td data-label="Услуги">
            <span v-if="item.orders_count > 0">{{ item.active_orders_count }} из {{ item.orders_count }}</span>
            <span v-else>0</span>
          </td>
        </tr>
        </tbody>
      </table>
      <a class="btn btn-small right" @click="$emit('close')">Закрыть</a>
    </div>
  </div>
</template>

<script>
export default {
  name: "ManagerClientsModal",
  props: {
    clients: Array
  }
}
</script>
