<template>
  <div class="popup">
    <div class="table-wrapper">
      <table>
        <caption>Клиенты менеджера</caption>
        <thead>
        <tr class="table-title">
          <th>Аккаунт</th>
          <th>Тариф</th>
          <th>Дата окончания</th>
          <th>Дата начала</th>
          <th>Действия</th>
        </tr>
        </thead>
        <tbody v-if="items.length > 0">
        <tr v-for="(item, index) in items" :key="index">
          <td data-label="Аккаунт">{{ item.account_name }}</td>
          <td data-label="Тариф">
            <template v-if="item.latest_order">
              {{ item.latest_order.service.category.name }} {{ item.latest_order.service.name }}
            </template>
          </td>
          <td data-label="Дата окончания">
            <template v-if="item.latest_order">
              {{ item.latest_order.expiration_date_format }}
            </template>
          </td>
          <td data-label="Дата начала">
            <template v-if="item.latest_order">
              {{ item.latest_order.created_at_format }}
            </template>
          </td>
          <td data-label="Действия">
            <a @click.prevent="deleteItem(item.id, index)" class="btn" href="#"><font-awesome-icon icon="trash-alt" /></a>
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
    clients: Array,
  },

  data() {
    return {
      items: this.clients
    }
  },

  methods: {
    async deleteItem(id, index) {
      if(confirm('Вы уверены, что хотите удалить аккаунт?')) {
        try {
          await this.$axios.$delete('/admin/manager/clients', {
            params: {
              id
            }
          });

          this.items.splice(index, 1);
        } catch (e) {
          console.error(e);
        }
      }
    }
  }
}
</script>
