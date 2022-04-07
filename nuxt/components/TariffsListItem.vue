<template>
  <div class="tariff" @click="$emit('buy', service)">
    <div class="module-border-wrap">
      <div class="tariff__body">
        <template v-if="service.type === 'subscribers'">
          <div class="likes">
            <div>
              {{ service.parameters.subscribers }}
              <font-awesome-icon icon="users" />
            </div>
          </div>
          <div class="description-wrapper">
            <div class="description">
              <span class="description__text description__text--mobile">подписчиков - единоразово</span>
              <span class="description__text description__text--desktop">подписчиков</span>
            </div>
            <div class="price">
              <b class="period">единоразово</b>
              <div class="value">{{ service.price_formatted }} руб.</div>
              <!-- <a href="#" class="help" @click.stop.prevent="openChat(service)">Заказать</a> -->
            </div>
          </div>
        </template>
        <template v-else>
          <div class="likes">
            <div>
              {{ service.parameters.likes }}
              <font-awesome-icon icon="heart" />
            </div>
            <div class="views views--mobile">
              <b>{{ service.parameters.views }}</b>
              <font-awesome-icon icon="eye" />
            </div>
          </div>
          <div class="description-wrapper">
            <div class="description">
              <span
                class="description__text description__text--mobile"
              >на {{ service.parameters.posts }} постов - {{ service.periodindays }} дней</span>
              <span
                class="description__text description__text--desktop"
              >на {{ service.parameters.posts }} постов + статистика (охват и сохранения)</span>
              <div class="views views--desktop">
                <b>{{ service.parameters.views }}</b>
                <font-awesome-icon icon="eye" />
              </div>
              <template
                v-if="service.parameters.igtv_unlim && service.parameters.igtv_unlim === '1'"
              >
                <div>
                  <span class="unlimited">Безлимит</span> на Видео и IGTV
                </div>
              </template>
              <template v-if="service.parameters.bonus">+ Бонус: {{ service.parameters.bonus }}</template>
            </div>
            <div class="price">
              <b class="period">{{ service.periodindays }} дней</b>
              <div class="value">{{ service.price_formatted }} руб.</div>
              <!-- <a href="#" class="help" @click.stop.prevent="openChat(service)">Заказать</a> -->
            </div>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TariffsListItem",
  props: ['service'],

  methods: {
    openChat(service) {
      if (!window.jivo_api) {
        return false;
      }

      jivo_api.setCustomData([
        {
          title: "Выбранный тариф",
          content: `${service.name} (${service.type}) — ${service.price} руб.`,
        }
      ]);

      jivo_api.open();
    }
  }
}
</script>

<style scoped>
.help {
  border: 1px solid #fff;
  padding: 1px 15px;
  display: inline-block;
  border-radius: 20px;
  color: #fff;
  text-decoration: none;
  font-weight: 600;
  margin: 10px 0 0;
  font-size: 14px;
}
.help:hover {
  background: #fff;
  color: #934392;
}

.help:before {
  content: "";
  background: url("data:image/svg+xml,%3Csvg version='1.1' xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 32 32'%3E%3Cpath fill='%23FFF' d='M14 22h4v4h-4zM22 8c1.105 0 2 0.895 2 2v6l-6 4h-4v-2l6-4v-2h-10v-4h12zM16 3c-3.472 0-6.737 1.352-9.192 3.808s-3.808 5.72-3.808 9.192c0 3.472 1.352 6.737 3.808 9.192s5.72 3.808 9.192 3.808c3.472 0 6.737-1.352 9.192-3.808s3.808-5.72 3.808-9.192c0-3.472-1.352-6.737-3.808-9.192s-5.72-3.808-9.192-3.808zM16 0v0c8.837 0 16 7.163 16 16s-7.163 16-16 16c-8.837 0-16-7.163-16-16s7.163-16 16-16z'%3E%3C/path%3E%3C/svg%3E%0A");
  width: 16px;
  height: 16px;
  display: inline-block;
  vertical-align: middle;
  margin: 0 8px 0 0;
}

.help:hover:before {
  background: url("data:image/svg+xml,%3Csvg version='1.1' xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 32 32'%3E%3Cpath fill='%23934392' d='M14 22h4v4h-4zM22 8c1.105 0 2 0.895 2 2v6l-6 4h-4v-2l6-4v-2h-10v-4h12zM16 3c-3.472 0-6.737 1.352-9.192 3.808s-3.808 5.72-3.808 9.192c0 3.472 1.352 6.737 3.808 9.192s5.72 3.808 9.192 3.808c3.472 0 6.737-1.352 9.192-3.808s3.808-5.72 3.808-9.192c0-3.472-1.352-6.737-3.808-9.192s-5.72-3.808-9.192-3.808zM16 0v0c8.837 0 16 7.163 16 16s-7.163 16-16 16c-8.837 0-16-7.163-16-16s7.163-16 16-16z'%3E%3C/path%3E%3C/svg%3E%0A");
}
</style>
