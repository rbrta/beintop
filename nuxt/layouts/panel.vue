<template>
  <div id="page">
    <Header :menu-items="menuItems" />
    <div class="main-block">
      <Nuxt />
    </div>
  </div>
</template>

<style lang="scss">
@import "~/assets/sass/flex.scss";
@import "~/assets/sass/clientpage.scss";
</style>

<script>
import Header from '~/components/Header'

export default {
  components: {
    Header,
  },

  data () {
    return {
      menuItems: [
        {
          title: 'Клиенты',
          link: '/manager',
          icon: 'user'
        },
        {
          title: 'Тарифы',
          link: '/manager/tariffs',
          icon: 'list'
        },
      ]
    }
  },

  head() {
    return {
      title: 'Личный кабинет'
    }
  }
}
</script>
