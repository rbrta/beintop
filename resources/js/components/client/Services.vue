<template>
    <div>
        <service-details v-if="details" :service="details" :user="user" mode="newOrder"></service-details>
        <div v-else class="table-wrapper">
            <table>
                <thead>
                <tr>
                    <th>Услуга</th>
                    <th>Цена</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <tr :key="key" v-for="(service, key) in services">
                    <td data-label="Услуга"><div class="text-big">Тариф {{ service.category.name }}</div><div class="text-large">{{ service.name }}</div></td>
                    <td data-label="Цена"><div class="text-big price">{{ service.price }} рублей</div> <div class="text-small">{{ service.periodindays }} {{ $plur(service.periodindays, $plurString.days)}}</div></td>
                    <td data-label="Действия"><span class="btn" @click="details = service">Детали</span></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Services",
        props: ['services', 'user'],

        created() {
            this.$root.$on('clean-nav', () => {
                this.details = null;
            });
        },

        data() {
            return {
                details: null
            }
        },

        components: {
            'service-details' : require('./ServiceDetails').default,
        }
    }
</script>

<style scoped>
    .price {
        text-transform: none!important;
    }
</style>
