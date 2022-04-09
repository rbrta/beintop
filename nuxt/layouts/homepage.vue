<template>
  <div>
    <Header :menu-items="menuItems" />
    <Nuxt />
    <Footer />
  </div>
</template>

<style lang="scss">
@import "~/assets/sass/homepage.scss";
body {
  background-image: url(/images/background-backend.svg);
  background-position: bottom;
  background-repeat: no-repeat;
  background-size: cover;
}
</style>

<script>
import Header from '~/components/Header'
import Footer from '~/components/Footer'

export default {
  components: {
    Header,
    Footer,
  },

  computed: {
    menuItems() {
      const items = [];

      items.push({
        title: 'Выбрать тарифы',
        link: '#tariffs',
        icon: 'th'
      });

      if (this.$auth.loggedIn) {
        items.push({
          title: 'Кабинет',
          link: this.$auth.user.usertype === 'user'
            ? '/userpanel'
            : (this.$auth.user.usertype === 'manager' ? '/manager' : '/admin'),
          icon: 'user'
        })
      }

      return items;
    }
  }
}
</script>
