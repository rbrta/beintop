<template>
    <div class="table-wrapper">
        <table>
            <caption>Клиенты менеджера</caption>
            <thead>
                <tr class="table-title">
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Дата регистрации</th>
                    <th>Услуги</th>
                </tr>
            </thead>
            <tbody v-if="clients.length > 0">
                <tr v-for="(item, index) in clients" :key="index">
                    <td data-label="Имя">{{item.full_name}}</td>
                    <td data-label="Email">{{item.email}}</td>
                    <td data-label="Дата регистрации">{{ item.created_at }}</td>
                    <td data-label="Услуги">{{ item.orders_count }}</td>
                </tr>
            </tbody>
        </table>

        <a class="btn btn-small right" @click="$emit('close')">Закрыть</a>
    </div>
</template>

<script>
    

    export default {
        name: "AdminManagerClientsModal",
        props: ['idmanager'],
        data() {
            return {
                clients: [],
            }
        },

        created(){
            this.loadItems();
        },


        methods: {
            loadItems() {
                axios.get('#', {
                    params: {
                        action: 'getmanagerclients',
                        idmanager: this.idmanager
                    }
                }).then(response => {
                    this.clients = response.data.clients;
                })
            }
        },
    }
</script>

<style lang="scss">
.v--modal-box {
    padding: 2rem;
}

.btn.right {
    margin-left: auto;
    margin-right: 0;
    display: block;
    width: 100px;
    margin-top: 2rem;
}
   
</style>
