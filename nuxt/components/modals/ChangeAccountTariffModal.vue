<template>
  <div class="popup">
    <div class="popup__content">
      <div class="row1">
        Смена тарифа
      </div>
      <div class="row2">
        {{ description }}
      </div>
      <div class="row4">
        К оплате: <span class="price"><span>{{ service.price_formatted }}</span>{{ price }}</span> руб.
      </div>
      <div class="row5">
        Тариф будет изменен сразу после оплаты
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
  name: 'ChangeAccountTariffModal',
  props: {
    service: {
      type: Object,
      default: null
    },
    category: {
      type: Object,
      default: null
    },
    orderId: {
      type: String
    },
    price: {
      type: String
    }
  },

  computed: {
    description() {
      return this.category.name.replace('Тарифы', 'Тариф') + ' ' + this.service.name
    }
  },

  methods: {
    async pay() {
      try {
        const date = await this.$axios.$post('/user/accounts/change-tariff', {
          service_id: this.service.id,
          order_id: this.orderId,
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
</style>
