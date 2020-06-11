<template>
    <div class="content-table">
        <ul class="tabs">
            <li :class="[tab === 'active' ? 'active' : '']" @click="setTab('active')">Активные</li>
            <li :class="[tab === 'archive' ? 'active' : '']">Архивные</li>
            <li :class="[tab === 'add' ? 'active' : '']" @click="setTab('add')">Добавить</li>
        </ul>

        <orders v-if="tab === 'active'" :orders="orders" :user="user"></orders>
        <services v-else-if="tab === 'add'" :services="services" :user="user" ></services>
    </div>
</template>

<script>
    export default {
        name: "ClientArea",
        props: ['orders', 'services', 'user'],

        data() {
            return {
                tab: 'active',
            }
        },

        methods: {
            setTab(tab) {
                this.tab = tab;
                this.$root.$emit('clean-nav');
            }
        },

        components: {
            'services': require('./Services').default,
            'orders': require('./Orders').default,
        }
    }
</script>

<style scoped>

</style>
