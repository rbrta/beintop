<template>
  <div class="popup">
    <div class="popup-title">
      Новый клиент
    </div>
    <div class="popup__content">

      <section v-if="userCode">
        <div class="">Пользователь добавлен успешно, персональная ссылка:
          <b>{{ userLink }}</b>
        </div>
      </section>

      <section v-else>
        <div class="row">
          <div class="input-wrapper">
            <input @change="resetError" v-model="form.full_name" placeholder="Имя пользователя (не обязательно)" type="text">
          </div>
          <div class="input-wrapper">
            <input @change="resetError" v-model="form.account" placeholder="Instagram login*" type="text">
          </div>
          <div class="input-wrapper">
            <input @change="resetError" v-model="form.phone" placeholder="Номер телефона*" type="text">
          </div>
        </div>

        <div v-if="errorMessage.length > 0" class="row">
          <div class="error">{{ errorMessage }}</div>
        </div>

        <div class="row">
          <span class="btn" @click="save">Сохранить</span>
        </div>
      </section>

    </div>
  </div>
</template>

<script>
export default {
  name: 'AddClientModal',
  props: ['created'],

  data() {
    return {
      form: {
        full_name: '',
        account: '',
        phone: '',
      },

      userCode: null,

      errorMessage: '',
    }
  },

  computed: {
    userLink: function () {
      return process.env.baseUrl + '/login/' + this.userCode;
    }
  },


  methods: {
    resetError() {
      this.errorMessage = '';
    },

    save() {
      this.resetError();

      if(this.form.account === '') {
        this.errorMessage = "Укажите Instagram login!";
        return;
      }

      if(this.form.phone === '') {
        this.errorMessage = "Укажите номет телефона!";
        return;
      }

      this.$axios.post('manager/clients', this.form).then(response => {
        this.userCode = response.data.user.login_code;
        this.created(response.data);
      })
    }
  }
}
</script>
