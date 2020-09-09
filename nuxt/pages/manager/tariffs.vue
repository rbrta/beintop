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
            <td data-label="Название">{{ item.category.name }} {{ item.name }} ({{ item.periodindays }} дн.)</td>
            <td data-label="Условия">
              {{ item.likes }} лайков на {{ item.posts }} постов  <br>
              {{ item.views }} просмотров <br>
              <span v-if="item.bonus !== null">Бонус: {{ item.bonus }}</span>
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

export default {
  layout: 'panel',
  name: 'ManagersTariffs',
  middleware: 'manager',

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

  methods: {
    createOffer (tariff) {
      this.$modal.show(CreateOfferModal, {
        tariff: tariff
      }, {
        width: 500
      })
    }
  }
}
</script>

<style scoped>

</style>
