<template>
  <div>
    <Header :menu-items="menuItems" />
    <Nuxt />
    <Footer />
  </div>
</template>

<style lang="scss">
@import "~/assets/sass/homepage.scss";
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
          title: 'Наши преимущества',
          link: '#advantage',
          icon: 'star'
        },
        {
          title: 'Выбрать тариф',
          link: '#tariffs',
          icon: 'th'
        },
        {
          title: 'Личный кабинет',
          link: '/userpanel',
          icon: 'user'
        }
      ]
    }
  },
}
</script>
