<template>
  <div class="wrapper-content admin">
    <div class="content-table">
      <div class="table-wrapper" v-if="clients.length">
        <div class="flex j-end">
          <div @click="addClient" class="btn">Добавить клиента</div>
        </div>
        <table>
          <caption>Клиенты</caption>
          <thead>
          <tr class="table-title">
            <th>Имя</th>
            <th>Email</th>
            <th>Телефон</th>
            <th>Аккаунты</th>
            <th>Действия</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(client, index) in clients" :key="client.id">
            <td data-label="Имя">{{ client.full_name || '-' }}</td>
            <td data-label="Email">{{ client.email || '-' }}</td>
            <td data-label="Телефон">{{ client.phone || '-' }}</td>
            <td data-label="Аккаунты">{{ client.accounts_list }}</td>
            <td data-label="Действия" class="table-action">
              <a class="btn" @click.prevent="copyLink(client)" href="#" title="Скопировать ссылку для входа пользователя">
                <font-awesome-icon icon="link"/> Скопировать ссылку
              </a>
              <a class="btn" @click.prevent="showClientOrders(client)" href="#">
                Заказы
              </a>
              <a class="btn" @click.prevent="deleteClient(client)" href="#">
                <font-awesome-icon icon="trash-alt" /> Удалить
              </a>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
      <div v-else class="table-wrapper" style="text-align: center; padding: 30px 0">
        <div>У вас пока нет клиентов</div>
        <div @click="addClient" class="btn">Добавить</div>
      </div>
    </div>
  </div>
</template>

<script>
import AddClientModal from '~/components/modals/manager/AddClientModal'
import ClientOrders from "~/components/managers/ClientOrders";
import copy from 'copy-to-clipboard';

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

  data() {
    return {
      clients: []
    }
  },

  methods: {
    addClient() {
      this.$modal.show(AddClientModal, {
        created: (item) => {
          this.getClients();
        }
      })
    },

    showClientOrders(client) {
      this.$modal.show(ClientOrders, {
        client: client
      })
    },

    async getClients() {
      try {
        this.clients = await this.$axios.$get('/manager/clients');
      } catch (e) {
        console.error(e);
      }
    },

    copyLink(client) {
      if(copy(process.env.baseUrl + '/login/' + client.login_code)) {
        this.$toast.success('Ссылка скопирована в буфер обмена');
      }
    },

    async deleteClient(client) {
      if(confirm('Вы уверены, что хотите удалить клиента? Все его заказы и аккаунты будут так же удалены.')) {
        try {
          await this.$axios.$delete(`/manager/clients`, {
            params: {
              id: client.id
            }
          });

          const index = this.clients.indexOf(client);
          if(index !== -1) {
            this.clients.splice(index, 1);
          }
        } catch (e) {
          console.error(e);
        }
      }
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
