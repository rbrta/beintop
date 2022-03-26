<template>
  <header>
    <div class="main-menu">
      <div class="logo">
        <img alt="Be-in-top" src="/images/logo.svg">
        <span>Be-in-top</span>
      </div>

      <ul class="menu">
        <li v-for="item in menuItems"><font-awesome-icon v-if="item.icon" :icon="item.icon"/> <a :href="item.link">{{ item.title }}</a></li>
        <li v-if="$auth.loggedIn"><font-awesome-icon icon="sign-out-alt"/> <a href="#" @click.prevent="logout">Выход</a></li>
      </ul>

      <div @click="showMobileMenu = !showMobileMenu" class="mobile-menu-btn" id="menuBtn">
        <span></span>
        <span></span>
        <span></span>
      </div>

    </div>

    <div v-if="showMobileMenu" class="wrapper-mobile" id="menuMob">
      <div class="mobile-menu">
        <div v-for="item in menuItems"><a @click="showMobileMenu=false" :href="item.link">{{ item.title }}</a></div>
        <div><a href="#" @click.prevent="logout">Выход</a></div>
      </div>
    </div>

  </header>
</template>

<script>
export default {
  name: 'Header',
  props: {
    menuItems: {
      type: Array,
      default: () => {
        return [
          {
            title: 'Наши преимущества',
            link: '#advantage',
            icon: 'star'
          },
          {
            title: 'Выбрать тарифы',
            link: '#tariffs',
            icon: 'th'
          }
        ]
      }
    }
  },

  data() {
    return {
      showMobileMenu: false,
    }
  },

  methods: {
    async logout() {
      this.showMobileMenu = false;
      await this.$auth.logout();
      await this.$router.push('/');
    }
  }
}
</script>
