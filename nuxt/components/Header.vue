<template>
  <header>
    <div class="main-menu">
      <div class="logo">
        <img alt="Be-in-top" src="/images/logo.svg">
        <span>Be-in-top</span>
      </div>

      <ul class="menu">
        <li v-for="item in menuItems"><font-awesome-icon v-if="item.icon" :icon="item.icon"/> <a :href="item.link">{{ item.title }}</a></li>
      </ul>

      <div @click="showMobileMenu = !showMobileMenu" class="mobile-menu-btn" id="menuBtn">
        <span></span>
        <span></span>
        <span></span>
      </div>

    </div>

    <div v-if="showMobileMenu" class="wrapper-mobile" id="menuMob">
      <div class="mobile-menu">
        <div><a @click="showMobileMenu=false" class="scrollTo" href="#tariffs">Наши преимущества</a></div>
        <div><a @click="showMobileMenu=false" class="scrollTo" href="#tariffs">Выбрать тариф</a></div>
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
            title: 'Выбрать тариф',
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
  }
}
</script>
