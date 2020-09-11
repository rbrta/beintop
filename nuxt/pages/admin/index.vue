<template>
  <div>
    <div class="table-wrapper">
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
          <td data-label="Название">{{ item.category.name }} {{ item.name }}</td>
          <td data-label="Период">{{ item.periodindays }} дней</td>
          <td data-label="Стоимость">{{ item.price }} руб</td>
          <td data-label="Действия" class="table-action">
            <a @click.prevent="updateOrCreate(item)" class="btn" href="#">Изменить</a>
            <a @click.prevent="deleteItem(item)" class="btn" href="#">Удалить</a>
          </td>
        </tr>
        </tbody>
      </table>
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
      const data = await $axios.$get('/services');

      let services = [];

      for (let category in data) {
        if(data.hasOwnProperty(category)) {
          services = [...services, ...data[category]];
        }
      }

      return {
        services: services,
      };
    } catch (err) {
      console.error(err.response.data || err);
      error({ statusCode: err.response.status, message: err.response.statusText });
    }

    return {
      services: [],
    }
  },

  data() {
    return {
      services: [],
      categories: []
    }
  },

  created () {
    this.getCategories();
  },

  methods: {
    async getCategories () {
      this.categories = await this.$axios.$get('/services/categories');
    },

    updateOrCreate(service = null) {
      this.$modal.show(UpdateOrCreateTariffModal, {
        data: service,
        categories: this.categories,
        updated: (item) => {
          const index = this.services.indexOf(service);
          if(index !== -1) {
            this.services[index].name = item.name;
            this.services[index].bonus = item.bonus;
            this.services[index].periodindays = item.periodindays;
            this.services[index].price = item.price;
            this.services[index].likes = item.likes;
            this.services[index].posts = item.posts;
            this.services[index].views = item.views;
            this.services[index].igtv_unlim = item.igtv_unlim;
            this.services[index].category_id = item.category_id;
            this.services[index].category = item.category;
          }
        },
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

</style>
