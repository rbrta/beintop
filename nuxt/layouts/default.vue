<template>
  <div>
    <Header :menu-items="menuItems"/>
    <Nuxt />
  </div>
</template>

<style lang="scss">
body {
  background-image: url(/images/background-backend.svg);
  background-position: bottom;
  background-repeat: no-repeat;
  background-size: cover;
  margin-bottom: 50px;
}
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
