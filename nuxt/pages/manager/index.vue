<template>
    <div class="table-wrapper">
        
        <div class="flex j-end">
            <div @click="addClient" class="btn">Добавить клиента</div>
        </div>
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
                        <a class="btn" href="#" title="Копировать ссылку в буфер обмена"><i class="far fa-chart-bar"></i> Детали</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

import AddClientModal from '~/components/modals/manager/AddClientModal'

export default {
    layout: 'panel',
    name: 'ManagerClients',
    // middleware: 'manager',

    async asyncData({
        env,
        $axios
    }) {
        const data = await $axios.$get('/manager/clients');
        return {
            clients: data,
        };
    },


    methods: {
        addClient(service) {
            this.$modal.show(AddClientModal)
        }
    },

    components: {
        
    }
}
</script>

<style scoped>
</style>
