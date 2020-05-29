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
                <tr v-for="(item, index) in items" :key="index + item.name">
                    <td>{{ item.name }}</td>
                    <td>{{ item.periodindays }} дней</td>
                    <td>{{ item.price }} руб</td>
                    <td class="table-action">
                        <a class="btn" href="#">Изменить</a>
                        <a class="btn" href="#">Удалить</a>
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
            }
        },
        computed: {},
        methods: {
            addService() {
                this.$showModal(AddOrEditService);
            },
        }
    }
</script>

<style scoped>
</style>
