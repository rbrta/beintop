<template>
<div class="container-table">
	<div class="wrapper-content">
		<div class="wrapper-table">
			<div class="tab">
				Тарифы
			</div>
			<table>
				<thead>
					<tr class="table-title">
						<td>Название</td>
						<td>Период</td>
						<td>Стоимость</td>
						<td>Actions</td>
					</tr>
				</thead>
                <tr v-for="(item, index) in services" :key="index + item.name">
                    <td>{{ item.name }}</td>
                    <td>{{ item.periodindays }} дней</td>
                    <td>{{ item.price }} руб</td>
                    <td class="table-action">
                        <a @click.prevent="editService(item)" class="btn" href="#">Изменить</a>
                        <a @click.prevent="deleteService(item.id, index)" class="btn" href="#">Удалить</a>
                    </td>
                </tr>
			</table>
			<div class="add-btn">
				<a @click.prevent="addService" class="btn" href="#">Добавить</a>
			</div>
		</div>
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
                let _this = this;
                axios.delete('/admin/delete_service', {
                    params: { id }
                }).then(response => {
                    _this.getServices();
                    this.$alert('Тариф успешно удален');
                });
            }
        },
    }
</script>

<style scoped>
</style>
