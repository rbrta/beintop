<template>
  <div>
    <div class="popup">
      <div class="popup-title">
        {{ service.id ? 'Изменить' : 'Добавить'}} тариф
      </div>
      <div class="popup__content">
        <form @submit.prevent="submit">
          <div class="row">
            <div class="col">
              <div class="input-wrapper">
                <label>Название</label>
                <input placeholder="Название" v-model="service.name" type="text">
                <div v-for="(error, index) in getErrors('name')" :key="index" class="form-error">{{ error }}</div>
              </div>
            </div>
            <div class="col" v-if="service.type === 'likes'">
              <div class="input-wrapper">
                <label>Период (дней)</label>
                <input placeholder="Кол-во дней" v-model="service.periodindays" type="number">
                <div v-for="(error, index) in getErrors('periodindays')" :key="index" class="form-error">{{ error }}</div>
              </div>
            </div>
            <div class="col">
              <div class="input-wrapper">
                <label>Стоимость</label>
                <input placeholder="Стоимость" v-model="service.price" type="number">
                <div v-for="(error, index) in getErrors('price')" :key="index" class="form-error">{{ error }}</div>
              </div>
            </div>
          </div>
          <div v-if="service.type === 'likes'">
            <div class="row">
              <div class="col">
                <div class="input-wrapper">
                  <label>Лайки</label>
                  <input placeholder="Лайки" v-model="service.parameters.likes" type="number">
                  <div v-for="(error, index) in getErrors('parameters.likes')" :key="index" class="form-error">{{ error }}</div>
                </div>
              </div>
              <div class="col">
                <div class="input-wrapper">
                  <label>Посты</label>
                  <input placeholder="Посты" v-model="service.parameters.posts" type="number">
                  <div v-for="(error, index) in getErrors('parameters.posts')" :key="index" class="form-error">{{ error }}</div>
                </div>
              </div>
              <div class="col">
                <div class="input-wrapper">
                  <label>Просмотры</label>
                  <input placeholder="Просмотры" v-model="service.parameters.views" type="number">
                  <div v-for="(error, index) in getErrors('parameters.views')" :key="index" class="form-error">{{ error }}</div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="input-wrapper">
                  <label>Бонус</label>
                  <input placeholder="Бонус" v-model="service.parameters.bonus" type="text">
                </div>
              </div>
              <div class="col">
                <div class="input-wrapper">
                  <label>Выберите категорию</label>
                  <div class="select-wrap">
                    <select v-model="service.category_id">
                      <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="input-wrapper">
                  <div>
                    <label><input type="checkbox" v-model="service.parameters.igtv_unlim"> IGTV unlimit</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-else-if="service.type === 'subscribers'">
            <div class="row">
              <div class="col">
                <div class="input-wrapper">
                  <label>Количество подписчиков</label>
                  <input placeholder="0" v-model="service.parameters.subscribers" type="number">
                  <div v-for="(error, index) in getErrors('parameters.subscribers')" :key="index" class="form-error">{{ error }}</div>
                </div>
              </div>
              <div class="col">
                <div class="input-wrapper">
                  <label>Выберите категорию</label>
                  <div class="select-wrap">
                    <select v-model="service.category_id">
                      <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row" style="margin-bottom: 0!important">
            <div class="col">
              <div class="input-wrapper">
                <button class="btn">{{ service.id ? 'Сохранить' : 'Добавить'}}</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { FormValidation} from '@/components/mixins/formValidate'

export default {
  name: "UpdateOrCreateTariffModal",
  props: {
    data: Object,
    categories: Array,
    updated: Function,
    created: Function,
    serviceType: {
      type: String,
      default: 'likes'
    }
  },

  mixins: [FormValidation],

  data() {
    return {
      service: {
        id: null,
        name: '',
        periodindays: null,
        price: null,
        category_id: 1,
        type: 'likes',
        parameters: {
          likes: null,
          posts: null,
          views: null,
          igtv_unlim: false,
          bonus: null,
        }
      },
      types: {
        likes: {
          name: 'Лайки',
          fields: ['bonus', 'likes', 'posts', 'views', 'igtv_unlim']
        },
        subscribers: {
          name: 'Подписчики',
          fields: ['subscribers']
        }
      },
    }
  },

  created () {
    if(this.data) {
      Object.keys(this.service).forEach(field => {
        this.service[field] = this.data[field];
        if(this.data.parameters.igtv_unlim) {
          this.service.parameters.igtv_unlim = this.data.parameters.igtv_unlim === '1';
        }
      })
    } else {
      this.service.type = this.serviceType;
    }
  },

  methods: {
    async submit () {
      try {
        const data = await this.$axios.$post('/admin/services', {
          ...this.service,
          parameters: this.getAvailableParams(this.service.parameters, this.types[this.service.type].fields)
        });

        this.$toast.success(this.service.id ? 'Тариф успешно обновлен' : 'Тариф успешно добавлен');
        if(this.service.id) {
          this.updated(data);
        } else {
          this.created(data);
          this.$emit('close');
        }
      } catch (e) {
        this.errors = e.response.data.errors || {};
      }
    },

    getAvailableParams(obj, keys) {
      return keys.reduce((a,b)=> (a[b] = obj[b], a),{});
    }
  },

  watch: {
    'service.type': function(val) {
      if(val === 'subscribers') {
        this.service.periodindays = null;
      }
    }
  }
}
</script>

<style scoped>
.row {
  display: flex;
  margin: 0 -10px 1rem!important;
}

.input-wrapper {
  padding: 0 10px;
}

.input-wrapper input {
  border-radius: 15px!important;
}

.popup {
  padding: 3rem 2.5rem;
}

.col {
  width: 100%;
}

.popup .popup-title {
  margin-bottom: 1rem;
}

.select-wrap {
  border: solid 1px #EB5B9C;
  border-radius: 15px;
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

.popup .popup__content .input-wrapper input[type="checkbox"] {
   width: auto;
   display: inline-block;
}

.btn {
  margin: 0;
  border: 0;
  outline: none;
}

.form-error {
  font-size: 11px;
  color: red;
  margin-top: 10px;
}
</style>
