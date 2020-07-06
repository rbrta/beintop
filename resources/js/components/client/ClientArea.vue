<template>
    <div class="content-table">
        <ul class="tabs">
            <li :class="[tab === 'active' ? 'active' : '']" @click="setTab('active')">Активные</li>
            <li :class="[tab === 'archive' ? 'active' : '']" @click="setTab('archive')">Архивные</li>
            <li :class="[tab === 'add' ? 'active' : '']" @click="setTab('add')">Добавить</li>
        </ul>

        <orders v-if="tab === 'active'" :showDetails="showDetails" :orders="orders" :user="user"></orders>
        <orders v-if="tab === 'archive'" :showDetails="showDetails" :isarchive="true" :orders="orders" :user="user"></orders>

        <services v-else-if="tab === 'add'" :showDetails="showDetails" :services="services" :user="user" ></services>
    </div>
</template>

<script>
    export default {
        name: "ClientArea",
        props: {
            orders: Array, 
            services: Array, 
            user: Object, 
            showservice: {
                default: false
            }
        },

        data() {
            return {
                tab: 'active',
                showDetails: null,
            }
        },

        created() {
            this.showDetailsByID();

            this.$root.$on('clean-nav', () => {
                this.showDetails = null;
            });
        },

        methods: {
            setTab(tab) {
                this.tab = tab;
                this.$root.$emit('clean-nav');
            },

            showDetailsByID() {

                if(this.showservice == false || this.showservice == "") {
                    return;
                }

                // 1. look for exists service by id
                let order = this.orders.find(o => {
                    return o.service_id == this.showservice;
                });

                if(typeof order !== 'undefined') {
                    //show exists service details
                    this.showDetails = order;
                    return;
                }

                // 2. if service doesn't exist, show service for buy

                let service = this.services.find(s => {
                    return s.id == this.showservice;
                });

                this.tab = 'add';
                this.showDetails = service;
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
