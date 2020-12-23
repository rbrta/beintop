<template>
  <div class="table-wrapper">
    <table>
      <caption>Клиенты менеджера: {{ manager.full_name }}</caption>
      <thead>
      <tr class="table-title">
        <th>Имя</th>
        <th>Телефон</th>
        <th>Аккаунты</th>
        <th>Действия</th>
      </tr>
      </thead>
      <tbody v-if="clients.length > 0">
      <tr v-for="(client, index) in clients" :key="client.id">
        <td data-label="Имя">{{ client.full_name || '-' }}</td>
        <td data-label="Телефон">{{ client.phone || '-' }}</td>
        <td data-label="Аккаунты">{{ client.accounts_list }}</td>
        <td data-label="Действия">
          <a @click.prevent="deleteItem(client.id, index)" class="btn" href="#"><font-awesome-icon icon="trash-alt" /></a>
        </td>
      </tr>
      </tbody>
      <tbody v-else>
      <tr>
        <td colspan="4">Пока нет записей</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "AdminManagersClientPage",
  middleware: 'admin',
  layout: 'admin',

  async asyncData({ $axios, error, params }) {
    try {
      return await $axios.$get(`/admin/manager/${params.id}/clients`);
    } catch (err) {
      console.error(err.response.data || err);
      error({ statusCode: err.response.status, message: err.response.statusText });
    }
  },

  data() {
    return {
      manager: {},
      clients: []
    }
  },

  methods: {
    async deleteItem(id, index) {
      if(confirm('Вы уверены, что хотите удалить клиента? Все его заказы и аккаунты будут так же удалены.')) {
        try {
          await this.$axios.$delete(`/admin/manager/${this.$route.params.id}/clients`, {
            params: {
              id
            }
          });

          this.clients.splice(index, 1);
        } catch (e) {
          console.error(e);
        }
      }
    }
  }
}
</script>

<style scoped>

</style>