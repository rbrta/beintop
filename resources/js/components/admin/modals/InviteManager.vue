<template>
<modal-skeleton title="Пригласить менеджера">

    <div>
        <el-form ref="form" @submit.prevent.native="onSubmit">

            <el-row :gutter="30">
                <el-col :span="24">
                    <el-form-item label="Email"  prop="posts">
                        <el-input placeholder="Введите email" v-model="email"></el-input>
                    </el-form-item>

                    <el-form-item class="submit-button-wrapper">
                        <span class="submit-button">
                            <el-button round @click="onSubmit">Добавить</el-button>
                        </span>
                    </el-form-item>
                </el-col>
            </el-row>

        </el-form>
    </div>

</modal-skeleton>
</template>

<script>
export default {
    name: 'InviteManager',
    props: ['serviceItem', 'updated'],
    data() {
        return {
            email: '',
        }
    },
    
    methods: {
        onSubmit() {

            axios.post('#', {
                    action: 'invite',
                    email: this.email
            }).then(response => {
                this.updated(this.email);
                this.$emit('close');

                this.$alert('Запись добавлена. На указанный адрес было отправлено письмо с подтверждением');

            }).catch(error => {
                if (error.response.data.errors) {
                    let message = error.response.data.errors[Object.keys(error.response.data.errors)[0]]
                    message = message.toString();
                    this.$alert(message);
                }
            });
        }
    },
    
}
</script>

<style scoped>
.submit-button-wrapper {
    display: flex;
    justify-content: flex-end;
}

.submit-button .el-button {
    background: linear-gradient(89.8deg, #E164BE -0.56%, #FF74D8 -0.55%, #FF985E 97.67%);
    color: white;
    border: none;
}

.width100 {
    width: 100%;
}

.igtv-unlimit {
    margin-top: 40px;
}
</style>
<style>
.el-checkbox__input.is-checked .el-checkbox__inner,
.el-checkbox__input.is-indeterminate .el-checkbox__inner {
    background-color: #644595;
    border-color: #644595;
}

.el-checkbox__input.is-checked+.el-checkbox__label {
    color: #644595;
}
</style>
