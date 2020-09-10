<template>
  <div class="payment-message">
    <div class="wrapper">
      <div class="title">
        Оплата не завершена
      </div>
      <div v-if="$route.query.Message">{{ $route.query.Message }}</div>
      <div>
        <nuxt-link to="/userpanel">Перейти в кабинет</nuxt-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TinkoffFailedPayment",
  middleware: 'authorized',

  head() {
    return {
      title: 'Оплата не завершена'
    }
  },
}
</script>

<style scoped>
.payment-message{
  margin-top: 126px;
}
.payment-message .wrapper{
  max-width: 1251px;
  height: 342px;
  box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.25);
  background-color: white;
  margin: 0 auto;
  border-radius: 35px;
  text-align: center;
}
.payment-message .wrapper .title{
  font-size: 42px;
  color: #984493;
  padding-top: 79px;
}
.payment-message .wrapper a{
  width: 315px;
  height: 47px;
  background: linear-gradient(89.67deg, #E164BE -0.56%, #FF74D8 -0.55%, #FF985E 97.67%);
  border-radius: 50px;
  font-size: 20px;
  display: inline-block;
  margin-top: 63px;
  color: white;
  text-decoration: none;
  line-height: 2.2
}
</style>
