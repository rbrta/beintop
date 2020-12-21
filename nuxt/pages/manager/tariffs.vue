<template>
  <div class="wrapper-content admin">
    <div class="content-table">
      <div class="table-wrapper">
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
        </table>
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
      const data = await $axios.$get('/services');
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
    }
  },

  methods: {
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

</style>
