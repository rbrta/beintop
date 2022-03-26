<template>
    <div class="table-wrapper">
        <table>
            <caption>Тарифы</caption>
            <thead>
                <tr class="table-title">
                    <th>Название</th>
                    <th>Условия</th>
                    <th>Стоимость</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in services" :key="index + item.name">
                    <td data-label="Название">{{item.category.name}} {{ item.name }} ({{ item.periodindays }} дн.)</td>
                    <td data-label="Условия">
                        {{item.likes}} лайков на {{item.posts}} постов  <br>
                        {{item.views}} просмотров <br>
                        <span v-if="item.bonus !== null">Бонус: {{item.bonus}}</span>
                    </td>
                    <td data-label="Стоимость">{{ item.price_formatted }} руб</td>
                    <td data-label="Actions" class="table-action">
                        
                        <a @click.prevent="copyLink(item.id)" class="btn" href="#" title="Копировать ссылку в буфер обмена"><i class="fas fa-link"></i> Копировать</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    

    export default {
        name: "ManagerServiceTable",
        props: ['items', 'managerid'],
        data() {
            return {
                services: [],
                idManager: null,
            }
        },

        created(){
            this.services = this.items;
            this.idManager = this.managerid;
        },


        methods: {
            copyLink(idservice) {
                let link = window._laravel.app_url + '/buy_' + idservice + '_' + this.idManager;
                
                
                this.$copyText(link).then((e) => {
                    this.$alert('Ссылка скопирована в буфер обмена!')
                }, function (e) {
                    this.$alert('Произошла ошибка копирования')
                })
            }
        },
    }
</script>

<style lang="scss">

   
</style>
