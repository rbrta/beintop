<template>
  <section id="tariffs" class="tariffcontainer">
    <h1 class="title" v-if="socials && socials.length > 0">Выберите сеть</h1>
    <div class="text-center services-type">
      <button
        v-for="social in socials"
        :key="social.id"
        :class="{ active: currentSocialId === social.id }"
        @click="changeSocialId(social.id)"
      >{{ social.name }}</button>
    </div>
    <h2 class="title title--secondary" v-if="socials && socials.length > 0">Выберите услугу</h2>
    <div class="text-center services-type">
      <button
        :class="{ active: currentServiceType === 'likes' }"
        @click="changeServiceType('likes')"
      >Активность</button>
      <button
        :class="{ active: currentServiceType === 'subscribers' }"
        @click="changeServiceType('subscribers')"
      >Подписчики</button>
    </div>
    <div class="title title--secondary">{{ title }}</div>
    <div class="tariff-category">
      <div v-if="!hideCategories" class="tarif-category-title">
        <div
          v-for="category in visibleCategories"
          :key="category.id"
          :class="{ active: currentCategory === category.id }"
          @click="currentCategory = category.id
          "
        >Тарифы {{ category.name }}</div>
      </div>
      <div class="tarif-category-body">
        <TariffsListItem
          v-for="service in visibleServices"
          :key="service.id"
          :service="service"
          @buy="handleBuyClick"
        ></TariffsListItem>
      </div>
    </div>
  </section>
</template>

<script>
import TariffsListItem from "~/components/TariffsListItem";

export default {
  name: "TariffsList",
  props: {
    services: {
      type: Array,
      default: () => []
    },
    categories: {
      type: Array,
      default: () => []
    },
    socials: {
      type: Array,
      default: () => []
    },
    title: {
      type: String,
      default: 'Выберите Тариф'
    },
    hideCategories: {
      type: Boolean,
      default: false
    }
  },

  components: {
    TariffsListItem
  },

  created() {
    this.setCurrentCategory();
  },

  computed: {
    visibleCategories() {
      return this.categories.filter(category => this.currentServices.some(service => service.category_id === category.id));
    },

    visibleServices() {
      return this.currentServices.filter(tarrif => tarrif.category_id === this.currentCategory)
    },

    currentServices() {
      return this.services.filter(tarrif => tarrif.social_id === this.currentSocialId && tarrif.type === this.currentServiceType);
    }
  },

  data() {
    return {
      currentCategory: null,
      currentSocialId: 1,
      currentServiceType: 'likes'
    }
  },

  methods: {
    handleBuyClick(service) {
      this.$emit('buy', service)
    },

    changeSocialId(id) {
      this.currentSocialId = id;
      this.setCurrentCategory();
    },

    changeServiceType(type) {
      this.currentServiceType = type;
      this.setCurrentCategory();
    },

    // first show services from the maxi category
    // if the category "maxi" does not exist, then the current category will be the first category
    setCurrentCategory() {
      if (this.visibleCategories.length > 0) {
        const maxiCategory = this.visibleCategories.find(category => category.name === 'maxi');
        this.currentCategory = maxiCategory ? maxiCategory.id : this.visibleCategories[0].id;
      }
    }
  },
}
</script>

<style lang="scss">
@import "assets/sass/tariffs";

.title {
  font-weight: bold;
  font-size: 3.3rem;
  line-height: 1.5;
  text-align: center;
  color: #5c4998;

  &--secondary {
    font-size: 2.8rem;
  }
}

.services-type {
  margin-top: 2rem;
  margin-bottom: 40px;

  button {
    background: white;
    color: #bb56a1;
    width: 400px;
    height: 70px;
    border-radius: 40px;
    font-weight: 800;
    font-size: 1.4rem;
    text-transform: uppercase;
    margin: 0 10px;
    border: 5px solid #bb56a1;
    outline: none;
    cursor: pointer;

    &.active {
      background: linear-gradient(
        180deg,
        #b04e98 18.23%,
        #873e90 90.1%,
        #73307b 100%
      );
      color: white;
    }
  }
}
</style>
