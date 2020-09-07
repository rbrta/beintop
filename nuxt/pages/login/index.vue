<template>
  <form id="signup-form" method="post" @submit.prevent="login">
    <div class="login">
      <div class="wrapper">
        <div class="title">
          Авторизация
        </div>
        <div class="description">
          Для входа в личный кабинет необходимо ввести почту и пароль
        </div>
        <div class="inputs">
          <div class="intput-wrapper"><input v-model="form.email" name="email" placeholder="E-mail" type="email"></div>
          <div class="intput-wrapper"><input v-model="form.password" name="password" placeholder="Пароль" type="password"></div>
        </div>
        <div>
          <button class="login_btn" type="submit">
            Авторизоваться
          </button>
        </div>

        <template v-for="field in errors">
          <div class="errors" v-for="error in field">{{ error }}</div>
        </template>

        <div class="lost-password">
          <a href="/password/reset">Забыли пароль?</a>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
export default {
  name: 'admin',
  auth: 'guest',

  data() {
    return {
      form: {
        email: null,
        password: null
      },
      errors: {}
    }
  },

  methods: {
    async login() {
      try {
        this.cleanErrors();
        await this.$auth.loginWith('local', { data: this.form })
      } catch (err) {
        this.errors = err.response.data.errors || {};
      }
    },

    cleanErrors() {
      this.errors = {};
    }
  },

  head() {
    return {
      title: 'Авторизация'
    }
  },
}
</script>
