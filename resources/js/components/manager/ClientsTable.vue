<template>
    <div class="table-wrapper">
        <table>
            <caption>Клиенты</caption>
            <thead>
                <tr class="table-title">
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Услуги</th>
                    <th>Дата регистрации</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in clients" :key="index + item.name">
                    <td data-label="Имя">{{item.full_name}}</td>
                    <td data-label="Email">{{item.email}}</td>
                    <td data-label="Услуги">{{ item.orders.length }}</td>
                    <td data-label="Дата регистрации">{{ item.created_at }}</td>
                    <td data-label="Actions" class="table-action">
                        <a @click.prevent="showDetails(item)" class="btn" href="#" title="Копировать ссылку в буфер обмена"><i class="far fa-chart-bar"></i> Детали</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import clientDetailModal from './modals/ClientDetailModal';

    export default {
        name: "ManagerClientsTable",
        props: ['items',],
        data() {
            return {
                clients: [],
            }
        },

        created(){
            this.clients = this.items;
        },


        methods: {
            showDetails(client) {
                this.$showModal(clientDetailModal, {
                    items: client.orders
                }, 900)
            }
        },
    }
</script>

<style lang="scss">

   
</style>
