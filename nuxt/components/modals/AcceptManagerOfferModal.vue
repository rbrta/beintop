<template>
  <div class="popup">
    <div class="popup__content">
      <div class="row1">
        Активация тарифа
      </div>
      <div class="row2">
        {{ description }}
      </div>
      <div class="row4">
        К оплате: {{ service.price_formatted }} руб.
      </div>
      <div class="row" style="width: 100%">
        <div class="input-wrapper">
          <label for="account">Выберите аккаунт</label>
          <div class="select-wrap">
            <select id="account" v-model="account_id">
              <option v-for="account in accounts" :value="account.id">{{ account.account_name }}</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row5">
        Тариф будет активирован сразу после оплаты
      </div>
      <div class="row6">
        <a href="#" @click.prevent="pay">
          Перейти к оплате
        </a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AcceptManagerOfferModal',
  props: {
    service: {
      type: Object,
      default: null
    },
    offer: {
      type: Object
    },
  },

  created () {
    this.getAccounts();
  },

  data() {
    return {
      accounts: [],
      account_id: null
    }
  },

  computed: {
    description() {
      return this.service.category.name.replace('Тарифы', 'Тариф') + ' ' + this.service.name
    }
  },

  methods: {
    async getAccounts() {
      this.accounts = await this.$axios.$get('/user/accounts');
      this.account_id = this.accounts[0].id;
    },

    async pay() {
      try {
        const date = await this.$axios.$post('/user/accept-offer', {
          service_id: this.service.id,
          offer_id: this.offer.id,
          account_id: this.account_id
        })

        this.$emit('close');
        window.location.href = date.redirect_url;
      } catch (err) {
        console.error(err)
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.popup {
  width: 849px;
  max-width: 95%;
  margin: 0 auto;

  &__content {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .row1 {
    font-family: Montserrat;
    font-style: normal;
    font-weight: bold;
    font-size: 50px;
    line-height: 1;
    text-align: center;
    color: #5C4998;
    margin-top: 2rem;
  }

  .row2 {
    font-family: Montserrat;
    font-style: normal;
    font-weight: normal;
    font-size: 30px;
    line-height: 37px;
    text-align: center;
    color: #5C4998;
    margin-top: 1rem;
  }

  .row3 {
    display: flex;
    flex-direction: column;

    input {
      display: block;
      width: 100%;
      margin-top: 1rem;
      box-sizing: border-box;
      border-radius: 81px;
      border: 1px solid gray;
      font-size: 30px;
      line-height: 37px;
      font-style: normal;
      font-weight: normal;
      padding: 20px 40px;
    }
  }

  .row4 {
    margin-top: 2rem;
    font-style: normal;
    font-weight: bold;
    font-size: 36px;
    line-height: 44px;
    text-align: center;
    color: #5C4998;
  }

  .row5 {
    margin-top: 1rem;
    font-style: normal;
    font-weight: normal;
    font-size: 20px;
    line-height: 1;
    text-align: center;
    color: #5C4998;
    width: 460px;
    max-width: 100%;
  }

  .row6 {
    margin-top: 2rem;
    margin-bottom: 2rem;

    a {
      max-width: 100%;
      width: 393.98px;
      height: 79px;
      font-family: Montserrat;
      font-style: normal;
      font-weight: normal;
      font-size: 27px;
      line-height: 75px;
      background: linear-gradient(89.77deg, #E164BE -0.56%, #FF74D8 -0.55%, #FF985E 97.67%);
      display: inline-block;
      text-align: center;
      text-decoration: none;
      border-radius: 50px;
      color: white;
    }
  }

  textarea:focus,
  input:focus {
    outline: none;
  }

  @media(max-width: 460px) {
    .row1 {
      font-size: 30px;
    }

    .row2 {
      font-size: 24px;
    }

    .row3 input {
      padding: 10px 25px;
      font-size: 18px;
    }

    .row4 {
      margin-top: 2rem;
      font-size: 26px;
      line-height: 1;
    }

    .row5 {
      font-size: 14px;
      line-height: 1;
    }

    .row6 {
      width: 100%;

      a {
        font-size: 20px;
        font-weight: bold;
        line-height: 1;
        display: block;
        height: auto;
        padding: 20px;
      }
    }

  }
}

.price {
  position: relative;

  span {
    position: absolute;
    left: 0;
    top: -25px;
    text-decoration: line-through;
    font-size: 17px;
    font-weight: 600;
  }
}
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
}
</style>
