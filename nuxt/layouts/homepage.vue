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

  computed: {
    menuItems() {
      const items = [];

      if(this.$route.name === 'subscribers') {
        items.push({
          title: 'Активность',
          link: '/',
          icon: 'heart'
        });
      } else {
        items.push(
            {
              title: 'Подписчики',
              link: '/subscribers',
              icon: 'users'
            }, {
              title: 'Наши преимущества',
              link: '#advantage',
              icon: 'star'
            }
        );
      }

      items.push({
            title: 'Выбрать тарифы',
            link: '#tariffs',
            icon: 'th'
      });

      if(this.$auth.loggedIn) {
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
