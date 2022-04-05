<template>
  <div>
    <div class="table-wrapper">
      <div class="tabs-wrapper">
        <div class="tabs-header tabs-header--socials">
          <ul>
            <li
              v-for="social in socials"
              :key="social.id"
              @click="socialType = social.code"
              :class="{ active: socialType === social.code }"
            >{{ social.name }}</li>
          </ul>
        </div>

        <div class="tabs-header">
          <ul>
            <li
              @click="servicesType = 'likes'"
              :class="{ active: servicesType === 'likes' }"
            >Активность</li>
            <li
              @click="servicesType = 'subscribers'"
              :class="{ active: servicesType === 'subscribers' }"
            >Подписчики</li>
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
              <tr v-for="item in currentServices" :key="item.id">
                <td
                  data-label="Название"
                >{{ item.category ? item.category.name : '' }} {{ item.name }}</td>
                <td data-label="Период">
                  <template v-if="item.periodindays !== null">{{ item.periodindays }} дней</template>
                  <template v-else>-</template>
                </td>
                <td data-label="Стоимость">{{ item.price }} руб</td>
                <td data-label="Действия" class="table-action">
                  <a @click.prevent="updateOrCreate(item)" class="btn" href="#">Изменить</a>
                  <a @click.prevent="deleteItem(item)" class="btn" href="#">Удалить</a>
                </td>
              </tr>
            </tbody>
            <tfoot class="text-center" v-if="!services.length > 0">
              <tr>
                <td colspan="4">
                  <p class="no-items">Тарифов не найдено</p>
                </td>
              </tr>
            </tfoot>
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
      const data = await $axios.$get('/services/');

      return {
        ...data
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
      socialType: 'instagram'
    }
  },

  computed: {
    currentServices() {
      return this.services.filter(service => service.type === this.servicesType && service.social?.code === this.socialType)
    }
  },

  methods: {
    updateOrCreate(service = null) {
      this.$modal.show(UpdateOrCreateTariffModal, {
        data: service,
        categories: this.categories,
        serviceType: this.servicesType,
        updated: (item) => this.getServices(),
        created: (item) => this.services.push(item),
        social_id: this.socials.find(social => social.code === this.socialType).id
      }, {
        width: 880
      })
    },

    async deleteItem(service) {
      if (confirm('Вы уверены, что хотите удалить данный тариф?')) {
        await this.$axios.$delete('/admin/services', {
          params: {
            id: service.id
          }
        });

        const index = this.services.indexOf(service);
        if (index !== -1) {
          this.services.splice(index, 1);
        }

        this.$toast.success('Тариф успешно удален');
      }
    }
  }
}
</script>

<style scoped lang="scss">
.tabs-body {
  border: 1px solid #e9e9e9;
  border-radius: 0 0 30px 30px;
  padding: 20px 0 0;
}

.tabs-header {
  ul {
    margin: 0 0 -1px 0;
    padding: 0;
    list-style: none;
    display: flex;
  }

  ul > li {
    border: 1px solid #e9e9e9;
    padding: 10px;
    width: 200px;
    text-align: center;
    margin-right: -1px;
    border-radius: 25px 0 0 0;
    cursor: pointer;
  }

  ul > li.active {
    background: #b858c3;
    border-color: #b858c3;
    color: white;
  }

  ul > li + li {
    border-radius: 0;
  }

  ul > li:last-child {
    border-radius: 0 25px 0 0;
  }

  &--socials {
    margin-bottom: 24px;

    ul {
      justify-content: center;
      & > li {
        border-radius: 25px 0 0 25px;
      }

      & > li + li {
        border-radius: 0;
      }

      & > li:last-child {
        border-radius: 0 25px 25px 0;
      }
    }
  }
}
.no-items {
  padding: 20px 0;
}
</style>
