<template>
  <div class="table-wrapper">
    <table>
      <caption>Менеджеры</caption>
      <thead>
      <tr class="table-title">
        <th>Имя</th>
        <th>Клиенты</th>
        <th>Статус</th>
        <th>Действия</th>
      </tr>
      </thead>
      <tbody v-if="managers.length > 0">
      <tr v-for="(item, index) in managers" :key="item.id">
        <td data-label="Имя">{{ item.full_name }}</td>
        <td data-label="Клиенты">{{ item.clients_count }}</td>
        <td data-label="Статус">{{ item.status && item.status === 'invited' || item.full_name === 'Invited Manager' ? 'ожидает подтверждения' : 'активный' }}</td>
        <td data-label="Actions" class="table-action">
          <nuxt-link class="btn" tag="a" :to="`/admin/managers/${item.id}`"><font-awesome-icon icon="users" /></nuxt-link>
          <a v-if="item.id" @click.prevent="deleteItem(item.id, index)" class="btn" href="#"><font-awesome-icon icon="trash-alt" /></a>
        </td>
      </tr>
      </tbody>
      <tbody v-else>
      <tr>
        <td colspan="4">Пока нет записей</td>
      </tr>
      </tbody>
    </table>
    <div class="add-btn">
      <a @click.prevent="inviteManagerModal" class="btn" href="#">Добавить</a>
    </div>
  </div>
</template>

<script>
import DeleteManagerModal from '@/components/modals/admin/DeleteManagerModal'
import InviteManagerModal from '@/components/modals/admin/InviteManagerModal'

export default {
  name: "AdminManagersPage",
  middleware: 'admin',
  layout: 'admin',

  async asyncData({ $axios, error }) {
    try {
      return {
        managers: await $axios.$get('/admin/managers'),
      };
    } catch (err) {
      console.error(err.response.data || err);
      error({ statusCode: err.response.status, message: err.response.statusText });
    }

    return {
      managers: [],
    }
  },

  methods: {
    async getManagers() {
      this.managers = await this.$axios.$get('/admin/managers');
    },

    deleteItem(manager_id, index) {
      this.$modal.show(DeleteManagerModal, {
        id: manager_id,
        managers: this.managers,
        deleted: () => this.getManagers()
      })
    },

    inviteManagerModal() {
      this.$modal.show(InviteManagerModal, {
        created: (email) => {
          this.managers.push({ full_name: email, clients_count: 0, status: 'invited' });
        },
      });
    }
  }
}
</script>

<style scoped>

</style>
