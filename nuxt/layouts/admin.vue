<template>
  <div id="page">
    <Header :menu-items="menuItems" />
    <div class="main-block">
      <div class="wrapper-content admin">
        <div class="content-table">
          <Nuxt />
        </div>
      </div>
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
          title: 'Тарифы',
          link: '/admin',
          icon: 'list'
        },
        {
          title: 'Менеджеры',
          link: '/admin/managers',
          icon: 'users'
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
