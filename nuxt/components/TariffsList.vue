<template>
  <section id="tariffs" class="tariffcontainer">
    <div class="tariffcontainer-title">
      {{ title }}
    </div>
    <div class="tariff-category">
      <div v-if="!hideCategories" class="tarif-category-title">
        <div v-for="category in visibleCategories"
             :key="category.id"
             :class="{ active : currentCategory === category.id }"
             @click="currentCategory = category.id
        ">
          Тарифы {{ category.name }}
        </div>
      </div>
      <div class="tarif-category-body">
        <TariffsListItem v-for="service in visibleServices" :key="service.id" :service="service" @buy="handleBuyClick"></TariffsListItem>
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
    // first show services from the maxi category
    // if the category "maxi" does not exist, then the current category will be the first category
    if(this.visibleCategories.length > 0) {
      const maxiCategory = this.visibleCategories.find(category => category.name === 'maxi');
      this.currentCategory = maxiCategory ? maxiCategory.id : this.visibleCategories[0].id;
    }
  },

  computed: {
    /**
     * Show categories that have some services
     * @returns {*[]}
     */
    visibleCategories() {
      return this.categories.filter(category => this.services.some(service => service.category_id === category.id));
    },

    visibleServices() {
      return this.currentCategory
          ? this.services.filter(service => service.category_id === this.currentCategory)
          : [];
    }
  },

  data() {
    return {
      currentCategory: null
    }
  },

  methods: {
    handleBuyClick(service) {
      this.$emit('buy', service)
    }
  }
}
</script>

<style lang="scss">
@import "assets/sass/tariffs";
</style>
