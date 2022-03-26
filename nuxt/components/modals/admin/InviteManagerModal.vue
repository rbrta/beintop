<template>
  <div class="popup">
    <div class="popup-title">
      Пригласить менеджера
    </div>
    <div class="popup__content">
      <form @submit.prevent="submit">
        <div class="row">
          <div class="col">
            <div class="input-wrapper">
              <label>E-mail менеджера</label>
              <input type="email" v-model="email">
              <div v-for="(error, index) in getErrors('email')" :key="index" class="form-error">{{ error }}</div>
            </div>
          </div>
        </div>
        <div class="row">
          <button class="btn" type="submit">Подтвердить</button>
          <a class="btn" @click.prevent="$emit('close')" href="#">Отмена</a>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { FormValidation } from '@/components/mixins/formValidate'

export default {
  name: "InviteManagerModal",
  props: ['created'],

  mixins: [FormValidation],

  data() {
    return {
      email: null
    }
  },

  methods: {
    async submit() {
      try {
        await this.$axios.$post('/admin/managers', {
          email: this.email
        });

        this.created(this.email);
        this.$emit('close');
      } catch (e) {
        this.errors = e.response.data.errors || {};
      }
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
