<template>
<modal-skeleton title="Подтвердите удаление менеджера">

    <div>
        <el-form ref="form" @submit.prevent.native="onSubmit">

            <el-row :gutter="30">
                <el-col :span="24">
                    <el-form-item label="Перенести пользователей менеджеру" prop="posts">
                        <el-select v-model="newManagerId" filterable placeholder="Select">
                            <el-option v-for="item in managers" :key="item.id" :label="item.full_name +' ('+item.clients_count+')'" :value="item.id"></el-option>
                        </el-select>
                    </el-form-item>

                    <el-form-item class="buttons-wrapper">
                        <el-button round @click="onSubmit" class='success'>Подтвердить</el-button>
                        <el-button round @click="$emit('close')">Отмена</el-button>
                    </el-form-item>
                </el-col>
            </el-row>

        </el-form>
    </div>

</modal-skeleton>
</template>

<script>
export default {
    name: 'DeleteManager',
    props: ['idmanager', 'updated'],
    data() {
        return {
            managers: '',
            newManagerId: null,
        }
    },

    created() {
        axios.get('#', {
            params: {
                action: 'getManagers',
                exclude: this.idmanager,
            }
        }).then(response => {
            this.managers = response.data.managers;
        });
    },

    methods: {
        onSubmit() {

            axios.post('#', {
                action: 'removeManager',
                id: this.idmanager,
                newmanagerid: this.newManagerId,
            }).then(response => {
                this.updated(true);
                this.$emit('close');

                this.$alert('Запись Удалена.');

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

    .buttons-wrapper {
        margin-top: 2rem;
    }
    .buttons-wrapper .el-button.success {
        background: linear-gradient(89.8deg, #E164BE -0.56%, #FF74D8 -0.55%, #FF985E 97.67%);
        color: white;
        border: none;
    }

    .el-select {
        width: 100%;
    }


</style>
