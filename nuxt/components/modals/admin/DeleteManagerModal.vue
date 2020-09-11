<template>
  <div class="popup">
    <div class="popup-title">
      Подтвердите удаление менеджера
    </div>
    <div class="popup__content">
      <form @submit.prevent="submit">
        <div class="row">
          <div class="col">
            <div class="input-wrapper">
              <label>Перенести пользователей менеджеру</label>
              <div class="select-wrap">
                <select v-model="id_new">
                  <option :value="null">Выберите пользователя</option>
                  <option v-for="manager in otherManagers" :value="manager.id">{{ manager.full_name }} ({{ manager.clients_count }})</option>
                </select>
              </div>
              <div v-for="(error, index) in getErrors('id_new')" :key="index" class="form-error">{{ error }}</div>
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
  name: "DeleteManagerModal",
  props: ['id', 'managers', 'deleted'],
  mixins: [FormValidation],

  data() {
    return {
      id_new: null
    }
  },

  computed: {
    otherManagers() {
      return this.managers.filter(m => m.id !== this.id);
    }
  },

  methods: {
    async submit() {
      try {
        await this.$axios.$delete('/admin/managers', {
          params: {
            id: this.id,
            id_new: this.id_new
          }
        });

        this.$toast.success('Менеджер успешно удален');
        this.deleted();
        this.$emit('close');
      } catch (e) {
        this.errors = e.response.data.errors || {};
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

.btn {
  margin: 0;
  border: 0;
  outline: none;
}

.form-error {
  font-size: 13px;
  color: red;
  margin-top: 10px;
}
</style>
