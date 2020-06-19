<template>
<div class="table-wrapper">
	<table>
        <caption>Менеджеры</caption>
        <thead>
            <tr class="table-title">
                <th>Имя</th>
                <th>Клиенты</th>
                <th>Статус</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody v-if="managers.length > 0">
            <tr v-for="(item, index) in managers" :key="index + item.name">
                <td data-label="Имя">{{ item.full_name }}</td>
                <td data-label="Клиенты">0</td>
                <td data-label="Статус">{{ item.full_name == 'Invited Manager' ? 'ожидает подтверждения' : 'активный' }} </td>
                <td data-label="Actions" class="table-action">
                    <a @click.prevent="deleteItem(item.id, index)" class="btn" href="#">Удалить</a>
                </td>
            </tr>
        </tbody>
        <tbody v-else>
            <tr>
                <td colspan="4">Пока нет записей</td>
            </tr>
        </tbody>
    </table>
    <div class="add-btn">
        <a @click.prevent="inviteManagerModal" class="btn" href="#">Добавить</a>
    </div>
</div>
</template>

<script>
    import InviteManager from "./../admin/modals/InviteManager";
    
    export default {
        name: "AdminManagersTable",
        props: ['items'],
        data() {
            return {
                managers: null,
            }
        },
        created() {
            this.managers = this.items;
        },

        methods: {
            inviteManagerModal() {
                this.$showModal(InviteManager, {
                    updated: (email) => {
                       this.managers.push({full_name: email, clients_count: 0, status: 'invited'});
                    },  
                });
            },
           
            deleteItem(id, index){
                this.$confirm('Вы уверены, что хотите удалить запись?').then(()=>{
                    
                    
                    axios.delete('/admin/manager', {
                        params: { id }
                    }).then(response => {
                        this.managers.splice(index, 1);
                        this.$alert('Запись удалена');
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
