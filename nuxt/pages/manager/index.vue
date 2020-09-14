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
            <th>Аккаунт</th>
            <th>Тариф</th>
            <th>Дата оплаты</th>
            <th>Дата окончания</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item, index) in clients" :key="item.id">
            <td data-label="Аккаунт">{{ item.account_name }}</td>
            <td data-label="Тариф">
              <template v-if="item.latest_order && item.latest_order.service">
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
              <a class="btn" @click.prevent="copyLink(item)" href="#" title="Скопировать ссылку для входа пользователя">
                <font-awesome-icon icon="link"/> Скопировать ссылку
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
          this.clients.push(item);
        }
      })
    },

    copyLink(account) {
      if(copy(process.env.baseUrl + '/login/' + account.user.login_code)) {
        this.$toast.success('Ссылка скопирована в буфер обмена');
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
