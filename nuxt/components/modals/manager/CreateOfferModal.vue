<template>
  <div class="popup">
    <div class="popup-title">
      Создать ссылку
    </div>
    <div class="popup__content" v-if="!offerUrl">
      <div class="row">
        <div class="input-wrapper">
          <label for="client">Предложение для пользователя</label>
          <div class="select-wrap">
            <select id="client" v-model="form.user_id">
              <option :value="null">Выберите аккаунт</option>
              <option v-for="client in clients" :value="client.user_id">{{ client.account_name }}</option>
            </select>
          </div>
        </div>
        <div class="input-wrapper">
          <label for="price">Стоимость тарифа
            <template v-if="tariff.periodindays">
              (руб./{{ tariff.periodindays }} дн.)
            </template>
            <template v-else>
              (руб.)
            </template>
          </label>
          <input v-model="form.price" id="price" placeholder="Стоимость тарифа" type="text">
        </div>
      </div>
      <div class="row" style="text-align: center">
        <span class="btn" @click.prevent="createOffer">Получить ссылку</span>
      </div>
    </div>
    <div v-else class="popup__content">
      <div class="row">
        <div class="input-wrapper offer-link">
          <label for="offer">Уникальная ссылка на предложение</label>
          <input :value="offerUrl" id="offer" readonly type="text">
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import copy from 'copy-to-clipboard';

export default {
  name: "CreateOfferModal",
  props: {
    tariff: Object,
  },

  created() {
    this.getClients();

    this.form.price = parseFloat(this.tariff.price);
  },

  data() {
    return {
      clients: [],
      form: {
        user_id: null,
        price: 0
      },
      offerUrl: null
    }
  },

  methods: {
    async getClients() {
      this.clients = await this.$axios.$get('/manager/clients');
    },

    async createOffer() {
      try {
        const data = await this.$axios.$post('/manager/add-offer', {
          ...this.form,
          tariff_id: this.tariff.id
        })

        this.offerUrl = `${process.env.baseUrl}/login/${data.login_code}/${data.offer_id}`;
        if(copy(this.offerUrl)) {
          this.$toast.success('Ссылка скопирована в буфер обмена');
        }
      } catch (e) {
        console.error(e);
      }
    }
  }
}
</script>

<style scoped>
.select-wrap {
  border: solid 1px #EB5B9C;
  border-radius: 35px;
  width: 100%;
  display: block;
  padding: 0 1rem;
  font-size: 1.2rem;
  outline: none;
  overflow: hidden;
}

.select-wrap select {
  border: 0;
  width: 100%;
  padding: 1rem 0;
  outline: 0;
  background: transparent;
}

.offer-link label {
  margin-left: -30px!important;
}

.offer-link input {
  width: calc(100% + 60px)!important;
  margin: 0 -30px;
  font-size: 1rem!important;
}
</style>
