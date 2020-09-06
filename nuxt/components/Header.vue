<template>
  <header>
    <div class="main-menu">
      <div class="logo">
        <img alt="Be-in-top" src="/images/logo.svg">
        <span>Be-in-top</span>
      </div>

      <ul class="menu">
        <li><font-awesome-icon icon="star"/> <a href="#advantage">Наши преимущества</a></li>
        <li><font-awesome-icon icon="th"/> <a href="#tariffs">Выбрать тариф</a></li>
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

  data() {
    return {
      showMobileMenu: false,
    }
  }
}
</script>