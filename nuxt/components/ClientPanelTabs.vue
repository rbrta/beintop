<template>
  <ul class="tabs">
    <nuxt-link tag="li" :to="{ path: '/userpanel' }">Аккаунты</nuxt-link>
    <nuxt-link tag="li" :to="{ path: '/userpanel/new' }">Добавить</nuxt-link>
  </ul>
</template>

<script>
export default {
  name: "ClientPanelTabs"
}
</script>
