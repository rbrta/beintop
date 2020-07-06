<template>
    <div>
        <service-details v-if="details" :user="user" :service="details.service" :expirationDate="details.expiration_date" mode="details"></service-details>
        <div v-else class="table-wrapper">
            <table v-if="!isarchive">
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
                    <td data-label="Услуга"><div class="text-big">{{ order.service.category.name }}</div><div class="text-large">{{ order.service.name }}</div></td>
                    <td data-label="Аккаунт"><div class="text-default">{{ order.account_name }}</div></td>
                    <td data-label="Дата окончания"><div class="text-big">{{ order.expiration_date_format }}</div><div class="text-small">осталось {{ order.days }} дней</div></td>
                    <td data-label="Действия"><span class="btn" @click="details = order">Детали</span></td>
                </tr>
                </tbody>
            </table>
            <p style="text-align: center" v-else>Нет записей</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Orders",
        props: ['orders', 'user', 'showDetails', 'isarchive'],

        created() {
            this.$root.$on('clean-nav', () => {
                this.details = null;
            });

            if(typeof this.showDetails !== 'undefined') {
                this.details = this.showDetails;
            }
        },

        data() {
            return {
                details: null,
            }
        },

        components: {
            'service-details' : require('./ServiceDetails').default,
        }
    }
</script>

<style scoped>

</style>
