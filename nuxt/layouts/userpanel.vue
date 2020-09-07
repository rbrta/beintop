<template>
  <div id="page">
    <Header :menu-items="menuItems" />
    <div class="main-block">
      <div class="container-top">
        <div class="wrapper-content">
          <div class="row1"><b>Аккаунт:</b> {{ $store.state.auth.user.full_name }}
          </div>
        </div>
      </div>
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
          title: 'На главную',
          link: '/',
          icon: 'home'
        },
        {
          title: 'Услуги',
          link: '/userpanel',
          icon: 'list'
        },
      ]
    }
  },
}
</script>
