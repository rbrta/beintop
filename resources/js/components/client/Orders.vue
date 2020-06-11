<template>
    <div class="content-table">
        <ul class="tabs">
            <li @click="setTab('active')">Активные</li>
            <li>Архивные</li>
            <li @click="setTab('add')">Добавить</li>
        </ul>

        <div v-if="tab === 'active'">
            <order-details v-if="details" :data="details"></order-details>
            <div v-else class="table-wrapper">
                <table>
                    <thead>
                    <tr>
                        <th>Услуга</th>
                        <th>Аккаунт</th>
                        <th>Дата окончания</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr :key="key" v-for="(order, key) in orders">
                        <td data-label="Услуга"><div class="text-big">Тариф Max</div><div class="text-large">{{ order.service.name }}</div></td>
                        <td data-label="Аккаунт"><div class="text-default">{{ order.account_name }}</div></td>
                        <td data-label="Дата окончания"><div class="text-big">{{ order.expiration_date_format }}</div><div class="text-small">осталось {{ order.days }} дней</div></td>
                        <td data-label="Действия"><span class="btn" @click.prevent="showDetails(order)">Детали</span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div v-else-if="tab === 'add'">
            <services :services="services"></services>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ClientOrders",
        props: ['orders', 'services'],

        data() {
            return {
                details: null,
                tab: 'active',
            }
        },

        methods: {
            showDetails(order) {
                this.details = order;
            },

            setTab(tab) {
                this.tab = tab;
                this.details = null;
            }
        },

        components: {
            'order-details' : require('./OrderDetails').default,
            'services': require('./Services').default
        }
    }
</script>

<style scoped>

</style>
