<template>
  <div>
    <div class="table-wrapper">
      <div class="tabs-wrapper">
        <div class="tabs-header">
          <ul>
            <li @click="servicesType = 'likes'" :class="{ active : servicesType === 'likes' }">Лайки</li>
            <li @click="servicesType = 'subscribers'" :class="{ active : servicesType === 'subscribers' }">Подписчики</li>
          </ul>
        </div>
        <div class="tabs-body">
          <table>
            <caption>Тарифы</caption>
            <thead>
            <tr class="table-title">
              <th>Название</th>
              <th>Период</th>
              <th>Стоимость</th>
              <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in services" :key="item.id">
              <td data-label="Название">{{ item.category ? item.category.name : '' }} {{ item.name }}</td>
              <td data-label="Период">
                <template v-if="item.periodindays !== null">
                  {{ item.periodindays }} дней
                </template>
                <template v-else>
                  -
                </template>
              </td>
              <td data-label="Стоимость">{{ item.price }} руб</td>
              <td data-label="Действия" class="table-action">
                <a @click.prevent="updateOrCreate(item)" class="btn" href="#">Изменить</a>
                <a @click.prevent="deleteItem(item)" class="btn" href="#">Удалить</a>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="add-btn">
        <a @click.prevent="updateOrCreate()" class="btn" href="#">Добавить</a>
      </div>
    </div>
  </div>
</template>

<script>
import UpdateOrCreateTariffModal from '@/components/modals/admin/UpdateOrCreateTariffModal'

export default {
  name: "AdminPage",
  middleware: 'admin',
  layout: 'admin',

  async asyncData({ $axios, error }) {
    try {
      const data = await $axios.$get('/services/likes');

      return {
        services: data.services,
        categories: data.categories
      };
    } catch (err) {
      console.error(err.response.data || err);
      error({ statusCode: err.response.status, message: err.response.statusText });
    }

    return {
      services: [],
      categories: [],
    }
  },

  data() {
    return {
      services: [],
      categories: [],
      servicesType: 'likes',
    }
  },

  watch: {
    servicesType() {
      this.getServices();
    }
  },

  methods: {
    async getServices() {
      const data = await this.$axios.$get(`/services/${this.servicesType}`);
      this.services = data.services;
    },

    updateOrCreate(service = null) {
      this.$modal.show(UpdateOrCreateTariffModal, {
        data: service,
        categories: this.categories,
        serviceType: this.servicesType,
        updated: (item) => this.getServices(),
        created: (item) => this.services.push(item)
      }, {
        width: 880
      })
    },

    async deleteItem(service) {
      if(confirm('Вы уверены, что хотите удалить данный тариф?')) {
        await this.$axios.$delete('/admin/services', {
          params: {
            id: service.id
          }
        });

        const index = this.services.indexOf(service);
        if(index !== -1) {
          this.services.splice(index, 1);
        }

        this.$toast.success('Тариф успешно удален');
      }
    }
  }
}
</script>

<style scoped>
.tabs-body {
  border: 1px solid #e9e9e9;
  border-radius: 0 0 30px 30px;
  padding: 20px 0 0;
}

.tabs-header ul {
  margin: 0 0 -1px 0;
  padding: 0;
  list-style: none;
  display: inline-flex;
}

.tabs-header ul > li {
  display: inline-flex;
  border: 1px solid #e9e9e9;
  padding: 10px 60px;
  margin-right: -1px;
  border-radius: 25px 0 0 0;
  cursor: pointer;
}

.tabs-header ul > li.active {
  background: #b858c3;
  border-color: #b858c3;
  color: white;
}

.tabs-header ul > li + li {
  border-radius: 0;
}

.tabs-header ul > li:last-child {
  border-radius: 0 25px 0 0;
}
</style>
