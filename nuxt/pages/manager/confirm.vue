<template>
  <form @submit.prevent="submit">
    <div class="login">
      <div class="wrapper">
        <div class="title">
          Подтверждение аккаунта менеджера
        </div>
        <div class="description">
          Заполните, пожалуйста, все пустые поля
        </div>
        <div class="inputs">
          <div class="intput-wrapper">
            <input v-model="form.full_name" name="full_name" placeholder="Полное имя" type="text">
            <div v-for="(error, index) in getErrors('full_name')" :key="index" class="form-error">{{ error }}</div>
          </div>
          <div class="intput-wrapper">
            <input v-model="form.email" name="email" placeholder="E-mail" type="email" disabled>
          </div>
          <div class="intput-wrapper">
            <input v-model="form.password" name="password" placeholder="Пароль" type="password">
            <div v-for="(error, index) in getErrors('password')" :key="index" class="form-error">{{ error }}</div>
          </div>
          <div class="intput-wrapper">
            <input v-model="form.password_confirmation" name="password_confirmation" placeholder="Пароль еще раз" type="password">
            <div v-for="(error, index) in getErrors('password_confirmation')" :key="index" class="form-error">{{ error }}</div>
          </div>
        </div>
        <div>
          <button class="login_btn" type="submit">
            Сохранить
          </button>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import { FormValidation } from '@/components/mixins/formValidate'

export default {
  name: 'ManagerConfirmation',
  middleware: 'guest',
  mixins: [FormValidation],

  async asyncData({ query, error, $axios }) {
    if(!query.user && !query.token) error({ statusCode: 404, message: 'Not found' });

    const data = await $axios.$get('/manager/confirm', {
      params: {
        user: query.user,
        token: query.token
      }
    })

    return {
      form: {
        email: data.email,
        full_name: null,
        password: null,
        password_confirmation: null,
        user: query.user,
        token: query.token
      }
    };
  },

  methods: {
    async submit() {
      try {
        await this.$axios.$post('/manager/confirm', this.form);
        this.$toast.success('Подтверждение прошло успешно')
        await this.login();
      } catch (e) {
        this.errors = e.response.data.errors || {};
      }
    },

    async login() {
      await this.$auth.loginWith('local', { data: { email: this.form.email, password: this.form.password } });
      window.location.replace('/manager');
    }
  },

  head() {
    return {
      title: 'Подтверждение менеджера'
    }
  }
}
</script>

<style scoped>
.form-error {
  font-size: 11px;
  color: red;
  margin-top: 10px;
}
</style>
