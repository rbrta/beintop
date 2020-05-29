<template>
<modal-skeleton title="Добавить тариф">

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
            <el-form-item label="Лайки"  prop="likes">
                <el-input placeholder="Лайки" v-model="service.likes">
                </el-input>
            </el-form-item>
            </el-col>

            <el-col :span="12">
            <el-form-item label="Посты"  prop="posts">
                <el-input placeholder="Посты" v-model="service.posts">
                </el-input>
            </el-form-item>
            <el-form-item label="Просмотры"  prop="views">
                <el-input placeholder="Просмотры" v-model="service.views">
                </el-input>
            </el-form-item>
            <el-form-item label="Бонусные комментарии"  prop="bonus_comments">
                <el-input placeholder="Бонусные комментарии" v-model="service.bonus_comments">
                </el-input>
            </el-form-item>
            <el-form-item label="Бонусные посты" prop="bonus_posts">
                <el-input placeholder="Бонусные посты" v-model="service.bonus_posts">
                </el-input>
            </el-form-item>
            <el-form-item prop="igtv_unlim">
                <div class="btns">
                    <el-checkbox v-model="service.igtv_unlim">IGTV</el-checkbox>
                    <span class="submit-button"><el-button round @click="onSubmit">Сохранить</el-button></span>
                </div>
            </el-form-item>
            </el-col>
        </el-row>
     </el-form>
</div>

</modal-skeleton>
</template>

<script>
    export default {
       data() {
            return {
                categories: [],
                service: {
                    category_id: '1',
                    name: '1000',
                    periodindays: '30',
                    price: '2990',
                    likes: '1000',
                    posts: '30',
                    views: '3000',
                    bonus_comments: '10-15',
                    bonus_posts: '5',
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
                    bonus_сomments: [
                        { required: true, message: 'Укажите количество бонусных комментариев', trigger: 'blur' }
                    ],
                    bonus_posts: [
                        { required: true, message: 'Укажите количество бонусных постов', trigger: 'blur' }
                    ],
                }
            }
        },
        beforeMount() {
            axios.get('/admin/categories').then(response => {
                this.categories = response.data.categories;
            });
        },
        methods: {
             onSubmit() {
                 this.$refs.form.validate(async (valid) => {
                    if(!valid) { return; }
                    axios.post('/admin/add_service', 
                            this.service
                        ).then(response => {
                            this.$emit('close');
                            this.$alert('Тариф успешно добавлен');
                        }).catch(error => {
                            if(error.response.data.errors){
                                this.$alert(error.response.data.errors);
                            }
                        });
                 });
             }
        }
    }
</script>

<style scoped>
    .submit-button{
        float: right;
        margin-right: 20px;
    }

    .submit-button .el-button{
        background: linear-gradient(89.8deg, #E164BE -0.56%, #FF74D8 -0.55%, #FF985E 97.67%);
        color: white;
        border: none;
    }

    .width100{
        width: 100%;
    }

    .btns{
        margin-top: 40px;
    }

</style>
