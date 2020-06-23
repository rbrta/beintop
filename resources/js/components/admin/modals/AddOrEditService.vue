<template>
<modal-skeleton :title="title">

<div>
     <el-form :model="service" :rules="rules" ref="form" @submit.prevent.native="onSubmit">

         <el-row :gutter="30">
            <el-col :span="12">
                <el-form-item label="Выберите категорию" prop="category_id">
                    <el-select v-model="service.category_id" placeholder="Выберите категорию" class="width100">
                        <el-option
                            v-for="item in categories"
                            :key="item.name"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="Название тарифа" prop="name">
                    <el-input placeholder="Название тарифа" v-model="service.name">
                    </el-input>
                </el-form-item>
                <el-form-item label="Период (дней)"  prop="periodindays">
                    <el-input placeholder="Период (дней)" v-model="service.periodindays">
                    </el-input>
                </el-form-item>
                <el-form-item label="Стоимость"  prop="price">
                    <el-input placeholder="Стоимость" v-model="service.price">
                    </el-input>
                </el-form-item>
            </el-col>

            <el-col :span="12">
                <el-form-item label="Лайки"  prop="likes">
                    <el-input placeholder="Лайки" v-model="service.likes">
                    </el-input>
                </el-form-item>
                <el-form-item label="Посты"  prop="posts">
                    <el-input placeholder="Посты" v-model="service.posts">
                    </el-input>
                </el-form-item>
                <el-form-item label="Просмотры"  prop="views">
                    <el-input placeholder="Просмотры" v-model="service.views">
                    </el-input>
                </el-form-item>
                <el-form-item prop="igtv_unlim">
                    <div class="igtv-unlimit">
                        <el-checkbox v-model="service.igtv_unlim">IGTV unlimit</el-checkbox>
                    </div>
                </el-form-item>
            </el-col>
        </el-row>

        <el-row>
            <el-col :span=24>
                <el-form-item label="Бонус"  prop="bonus">
                    <el-input placeholder="Бонус" v-model="service.bonus">
                    </el-input>
                </el-form-item>
                
                <el-form-item class="submit-button-wrapper">
                    <span class="submit-button"><el-button round @click="onSubmit">Сохранить</el-button></span>
                </el-form-item>
            </el-col>
        </el-row>
        
     </el-form>
</div>

</modal-skeleton>
</template>

<script>
    export default {
       props: ['serviceItem', 'updated'],
       data() {
            return {
                app_url: '',
                categories: [],
                service: {
                    category_id: '',
                    name: '',
                    periodindays: '',
                    price: '',
                    likes: '',
                    posts: '',
                    views: '',
                    bonus: '',
                    igtv_unlim: true,
                },
                rules: {
                    category_id: [
                        { required: true, message: 'Укажите категорию', trigger: 'blur' },
                    ],
                    name: [
                        { required: true, message: 'Укажите название тарифа', trigger: 'blur' },
                    ],
                    periodindays: [
                        { required: true, message: 'Укажите период тарифа', trigger: 'blur' },
                    ],
                    price: [
                        { required: true, message: 'Укажите стоимость', trigger: 'blur' }
                    ],
                    likes: [
                        { required: true, message: 'Укажите количество лайков', trigger: 'blur' }
                    ],
                    posts: [
                        { required: true, message: 'Укажите количество постов', trigger: 'blur' }
                    ],
                    views: [
                        { required: true, message: 'Укажите количество просмотров', trigger: 'blur' }
                    ],
                    
                }
            }
        },
        beforeMount() {
            if(this.serviceItem){
                this.service = Object.assign({}, this.serviceItem);
            }
            axios.get('/admin/categories').then(response => {
                this.categories = response.data.categories;
            });

            this.app_url = window._laravel.app_url;
        },
        methods: {
             onSubmit() {
                 this.$refs.form.validate(async (valid) => {
                    if(!valid) { return; }

                    if(typeof this.service.igtv_unlim == 'undefined'){
                        this.service.igtv_unlim = 0;
                    }

                    axios.post('/admin/add_service', 
                            this.service
                        ).then(response => {
                            this.updated();
                            this.$emit('close');

                            if(this.serviceItem){
                                this.$alert('Тариф успешно изменен');
                            }else{
                                this.$alert('Тариф успешно добавлен');
                            }

                        }).catch(error => {
                            if(error.response.data.errors){
                                let message = error.response.data.errors[Object.keys(error.response.data.errors)[0]]
                                message = message.toString();
                                this.$alert(message);
                            }
                        });
                 });
             }
        },
        computed: {
            title: function () {
                if(this.serviceItem){
                    return 'Изменить тариф';
                }
                return 'Добавить тариф';
            }
        }
    }
</script>

<style scoped>
    .submit-button-wrapper{
        display: flex;
        justify-content: flex-end;
    }

    .submit-button .el-button{
        background: linear-gradient(89.8deg, #E164BE -0.56%, #FF74D8 -0.55%, #FF985E 97.67%);
        color: white;
        border: none;
    }

    .width100{
        width: 100%;
    }

    .igtv-unlimit{
        margin-top: 40px;
    }
</style>
<style>
    .el-checkbox__input.is-checked .el-checkbox__inner, 
    .el-checkbox__input.is-indeterminate .el-checkbox__inner {
        background-color: #644595;
        border-color: #644595;
    }

    .el-checkbox__input.is-checked+.el-checkbox__label{
        color: #644595;
    }
</style>
