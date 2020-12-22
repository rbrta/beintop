<template>
  <div class="wrapper-content admin">
    <div class="content-table">
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
                <th>Условия</th>
                <th>Стоимость</th>
                <th>Действия</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="(item, index) in services">
                <td data-label="Название">
                  <template v-if="item.category_id && categories[item.category_id]">
                    {{ categories[item.category_id].name }}
                  </template>
                  {{ item.name }}
                  <template v-if="item.periodindays">
                    ({{ item.periodindays }} дн.)
                  </template>
                </td>
                <td data-label="Условия">
                  <template v-if="item.type === 'subscribers'">
                    <div>{{ item.parameters.subscribers }} подписчиков</div>
                  </template>
                  <template v-else>
                    {{ item.parameters.likes }} лайков на {{ item.parameters.posts }} постов  <br>
                    {{ item.parameters.views }} просмотров <br>
                    <span v-if="item.parameters.bonus">Бонус: {{ item.parameters.bonus }}</span>
                  </template>
                </td>
                <td data-label="Стоимость">{{ item.price_formatted }} руб</td>
                <td data-label="Действия" class="table-action">
                  <a class="btn" href="#" title="Создать персональную ссылку" @click.prevent="createOffer(item)"><font-awesome-icon icon="link"/> Создать ссылку</a>
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
      </div>
    </div>
  </div>
</template>

<script>
import CreateOfferModal from '@/components/modals/manager/CreateOfferModal'
import { keyBy } from 'lodash';

export default {
  layout: 'panel',
  name: 'ManagersTariffs',
  middleware: 'manager',

  async asyncData({ $axios, error }) {
    try {
      const data = await $axios.$get('/services/likes');
      return {
        services: data.services,
        categories: keyBy(data.categories, 'id'),
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
      try {
        const data = await this.$axios.$get(`/services/${this.servicesType}`);
        this.services = data.services;
      } catch (err) {
        console.error(err);
      }
    },

    createOffer (tariff) {
      this.$modal.show(CreateOfferModal, {
        tariff: tariff
      }, {
        width: 500
      })
    }
  },
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

.no-items {
  padding: 20px 0;
}
</style>
