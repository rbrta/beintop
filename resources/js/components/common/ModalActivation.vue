<template>
  <div class="popup">
    <div class="popup__content">
      <div class="row1">Активация тарифа</div>
      <div class="row2">{{ description }}</div>
      <div class="row3">
        <div v-if="mode !== 'fromUserpanel'">
          <div class="intput-wrapper"><input v-model="form.account_name" placeholder="Имя профиля или ссылка" type="text"></div>
          <div class="intput-wrapper"><input v-model="form.phone" placeholder="Номер телефона" type="text"></div>
        </div>
      </div>
      <div class="row4">
        К оплате: {{ service.price_formatted}} Рублей
      </div>
      <div class="row5">
        Мы начнём выполнение заказа сразу после оплаты
      </div>
      <div class="row6">
        <a @click.prevent="pay" href="#">
          Перейти к оплате
        </a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ModalSkeleton",
  props: ['service', 'mode'],
  data() {
    return {
      order_id: '',
      form: {
        full_name: '',
        email: '',
        password: '',
        account_name: '',
        phone: '',
      }
    }
  },
  computed: {
    description() {
      return this.service.category.name.replace('Тарифы', 'Тариф') + ' ' + this.service.name;
    },
  },

  created(){

  },

  methods: {
    pay() {
      let url = this.mode === 'fromUserpanel' ? '/userpanel/add-new-order' : '/pay_service';

      axios.post(url, {
        ...this.form,
        service_id: this.service.id
      }).then(response => {
        if(response.data.redirect_url) {
          window.location.href = response.data.redirect_url;
        } else {
          this.$alert('Something went wrong');
        }
      }).catch(error => {
        if (error.response.data && error.response.data.errors) {
          let message = error.response.data.errors[Object.keys(error.response.data.errors)[0]]
          message = message.toString();
          this.$alert(message);
        }
      });
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
    line-height: 61px;
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
    line-height: 37px;
    text-align: center;
    color: #5C4998;
    width: 460px;
    max-width: 100%;
  }

  .row6 {
    margin-top: 1rem;
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
</style>
