<template>
  <div>
    <Header :menu-items="menuItems"/>
    <Nuxt />
  </div>
</template>

<style lang="scss">
@import "~/assets/sass/login.scss";
</style>

<script>
import Header from '~/components/Header'
import Footer from '~/components/Footer'

export default {
  components: {
    Header,
    Footer,
  },

  data() {
    return {
      menuItems: [
        {
          title: 'На главную',
          link: '/',
          icon: 'home'
        },
        {
          title: 'Личный кабинет',
          link: '/userpanel',
          icon: 'user'
        }
      ]
    }
  }
}
</script>
