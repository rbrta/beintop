<template>
<div class="table-wrapper">
	<table>
        <caption>Тарифы</caption>
        <thead>
            <tr class="table-title">
                <th>Название</th>
                <th>Период</th>
                <th>Стоимость</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in services" :key="index + item.name">
                <td data-label="Название">{{item.category.name}} {{ item.name }}</td>
                <td data-label="Период">{{ item.periodindays }} дней</td>
                <td data-label="Стоимость">{{ item.price }} руб</td>
                <td data-label="Actions" class="table-action">
                    <a @click.prevent="editService(item)" class="btn" href="#">Изменить</a>
                    <a @click.prevent="deleteService(item.id, index)" class="btn" href="#">Удалить</a>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="add-btn">
        <a @click.prevent="addService" class="btn" href="#">Добавить</a>
    </div>
</div>
</template>

<script>
    import AddOrEditService from "./../admin/modals/AddOrEditService";
    export default {
        name: "ServiceTable",
        props: ['items'],
        data() {
            return {
                services: this.items
            }
        },
        methods: {
            addService() {
                let _this = this;
                this.$showModal(AddOrEditService, {
                    updated: () => {
                       _this.getServices();
                    },  
                });
            },
            editService(item) {
                let _this = this;
                this.$showModal(AddOrEditService, {
                    serviceItem: item,
                    updated: () => {
                       _this.getServices();
                    },  
                });
            },
            getServices() {
                axios.get('/admin/get_services', 
                    this.service
                ).then(response => {
                    this.services = response.data.services;
                }).catch(error => {
                    console.log('getServices error: ' + error);
                });
            },
            deleteService(id, index){
                this.$confirm('Вы уверены, что хотите удалить запись?').then(()=>{
                    
                    
                    axios.delete('/admin/delete_service', {
                        params: { id }
                    }).then(response => {
                        this.getServices();
                        this.$alert('Тариф успешно удален');
                    });

                }); 
                

                
            }
        },
    }
</script>

<style lang="scss">

    a.add-btn {
        margin: 1rem auto;
        display: block;
    }
</style>
