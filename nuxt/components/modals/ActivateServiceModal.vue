<template>
  <div class="popup">
    <div class="popup__content">
      <div class="row1">
        <template v-if="service.type === 'subscribers'">
          Активация<br>услуги
        </template>
        <template v-else>
          {{ isProlongOrder ? 'Продление' : 'Активация' }} тарифа
        </template>
      </div>
      <div class="row2">
        {{ description }}
      </div>
      <div class="row3" v-if="!isProlongOrder">
        <div class="intput-wrapper">
          <select v-model="accountId" v-if="customAccountName === null">
            <option :value="null">Выберите аккаунт</option>
            <option v-for="account in accounts" :value="account.id">{{ account.account_name }}</option>
            <option value="new">Добавить новый</option>
          </select>
          <input ref="customAccountName" v-else v-model="customAccountName" placeholder="Имя профиля или ссылка" type="text">
        </div>
      </div>
      <div class="row4">
        К оплате: {{ service.price_formatted }} руб.
      </div>
      <div class="row5">
        <template v-if="isProlongOrder">
          Услуга будет продлена сразу после оплаты
        </template>
        <template v-else>
          Мы начнём выполнение заказа сразу после оплаты
        </template>
      </div>
      <div class="row6">
        <button @click.prevent="submit" :disabled="loading">
          Перейти к оплате
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ActivateServiceModal',
  props: {
    service: {
      type: Object,
      default: null
    },
    category: {
      type: Object,
      default: null
    },
    order: { // filled only for prolong order
      type: Object,
      default: null
    }
  },

  data() {
    return {
      loading: false,
      customAccountName: null,
      accountId: null
    }
  },

  created() {
    this.$store.dispatch('getOrders');

    if(this.order) {
      this.accountId = this.order.account_id;
    }
  },

  computed: {
    description() {
      return this.category.name.replace('Тарифы', 'Тариф') + ' ' + this.service.name
    },

    accounts() {
      return this.$auth.user.accounts;
    },

    orders() {
      return this.$store.state.orders;
    },

    isProlongOrder() {
      return this.order !== null;
    }
  },

  watch: {
    accountId(val) {
      // signaling that we need to show input for new account creation
      if(val === 'new') {
        this.customAccountName = '';
        this.accountId = null;
        this.$nextTick(() => this.$refs.customAccountName.focus());
      }
    }
  },

  methods: {
    async createAccount() {
      try {
        const account = await this.$axios.$post('/user/accounts', {
          name: this.customAccountName
        });

        // update user state that has list of all accounts
        await this.$auth.fetchUser();

        this.accountId = account.id;
        this.customAccountName = null;
      } catch (err) {
        console.error(err);
        this.loading = false;
      }
    },

    async createOrder() {
      try {
        const date = await this.$axios.$post('/user/orders', {
          service_id: this.service.id,
          account_id: this.accountId
        })

        this.$emit('close');

        // redirect to payment url
        this.$nextTick(() => window.location.href = date.redirect_url);
      } catch (err) {
        console.error(err);
        this.loading = false;
      }
    },

    async submit() {
      this.loading = true;

      // we must create new account before order
      if(this.customAccountName) {
        await this.createAccount();
      }

      // checking if an order of the same type is active
      // user cannot have two active tariffs for one account
      const order = this.orders.filter(order => order.service.type === 'likes')
                               .find(order => order.service.type === this.service.type);

      if(order && !this.isProlongOrder) { // ignore the condition if the user prolongs the order
        this.$toast.warning('Для этого аккаунта уже активирован тариф. Перейдите в детали текущего тарифа, чтобы изменить или продлить его.');
      } else {
        await this.createOrder();
      }

      this.loading = false;
    },
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

    input, select {
      display: block;
      width: 420px;
      margin: 1rem 0 0;
      box-sizing: border-box;
      border-radius: 81px;
      border: 1px solid gray;
      font-size: 26px;
      line-height: 37px;
      font-style: normal;
      font-weight: normal;
      outline: none;
      height: 80px;
      padding: 0 30px;
      -webkit-appearance: none;
      -moz-appearance: none;
    }

    select {
      background: transparent url("data:image/svg+xml,%3Csvg version='1.1' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='%235C4998' viewBox='0 0 24 24'%3E%3Cpath d='M7.406 8.578l4.594 4.594 4.594-4.594 1.406 1.406-6 6-6-6z'%3E%3C/path%3E%3C/svg%3E") no-repeat calc(100% - 25px) center;
    }
  }

  .row4 {
    margin-top: 1rem;
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
    line-height: 1.2;
    text-align: center;
    color: #5C4998;
    width: 430px;
    max-width: 100%;
  }

  .row6 {
    margin-top: 1rem;
    margin-bottom: 2rem;

    button {
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
      outline: none;
      border: none;
      cursor: pointer;

      &[disabled] {
        opacity: 0.7;
        cursor: default;
      }
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
</style>
