<template>
    <div class="table-wrapper">
        <table>
            <caption>Услуги</caption>
            <thead>
                <tr class="table-title">
                    <th>Услуга</th>
                    <th>Логин</th>
                    <th>Статус</th>
                    <th>Дата заказа</th>
                    <th>Дата окончания</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in orders" :key="index + item.name">
                    <td data-label="Услуга">{{item.service.category.name}} {{item.service.name}}</td>
                    <td data-label="Логин">{{item.account_name}}</td>
                    <td data-label="Статус">{{item.paid_status}}</td>
                    <td data-label="Дата заказа">{{ item.created_at }}</td>
                    <td data-label="Дата окончания">{{ item.expiration_date }}</td>
                </tr>
            </tbody>
        </table>

        <a class="btn btn-small right" @click="$emit('close')">Закрыть</a>
    </div>
</template>

<script>
    

    export default {
        name: "ManagerClientDetailModal",
        props: ['items'],
        data() {
            return {
                orders: [],
            }
        },

        created(){
            this.orders = this.items;
        },


        methods: {
            
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
