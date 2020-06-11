<template>
    <div class="content-table">
        <ul class="tabs">
            <li @click="setTab('active')">Активные</li>
            <li>Архивные</li>
            <li @click="setTab('add')">Добавить</li>
        </ul>

        <orders v-if="tab === 'active'" :orders="orders"></orders>
        <services v-else-if="tab === 'add'" :services="services"></services>
    </div>
</template>

<script>
    export default {
        name: "ClientArea",
        props: ['orders', 'services'],

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
