<template>
  <div class="popup">
    <div class="popup__content">
        <div class="row1">Активация тарифа</div>
        <div class="row2">{{ description }}</div>
        <div class="row3">
            <input v-model="form.full_name" placeholder="Полное имя" type="text">
            <input v-model="form.email" placeholder="Email" type="email" >
            <input v-model="form.password" placeholder="Пароль" type="password">
            <input v-model="form.account_name" placeholder="Имя профиля или ссылка" type="text">
        </div>
        <div class="row4">
            К оплате: {{ service.price}} Рублей
        </div>
        <div class="row5">
            Мы начнём выполнение заказа сразу после оплаты
        </div>
        <div class="row6">
            <a @click.prevent="pay" href="#">
                Перейти к оплате
            </a>
        </div>
    </div>
    <div v-show="false">
        <form ref="payment_form" name="payment" method="post" action="https://sci.interkassa.com/" accept-charset="UTF-8">
            <input type="hidden" name="ik_co_id" value="5ed3d7051ae1bd39008b457b"/>
            <input type="hidden" name="ik_pm_no" value="ID_4233"/>
            <input type="hidden" name="ik_am" :value="service.price"/>
            <input type="hidden" name="ik_cur" value="RUB"/>
            <input type="hidden" name="ik_desc" :value="description"/>
            <input type="submit" value="Pay">
        </form>
    </div>
  </div>
</template>


<script>
    export default {
        name: "ModalSkeleton",
        props: ['service'],
        data() {
            return {
                order_id: '',
                form: {
                    full_name: '',
                    email: '',
                    password: '',
                    account_name: ''
                }
            }
        },
        computed: {
            description(){
                return this.service.category.name.replace('Тарифы','Тариф')+' '+this.service.name;
            },
        },
        methods: {
            pay() {
                axios.post('/pay_service', 
                    { ...this.form, service_id: this.service.id }
                ).then(response => {
                    this.order_id = "ID_" + response.data.order_id;
                    this.$refs.payment_form.submit();
                }).catch(error => {
                    if(error.response.data && error.response.data.errors){
                        let message = error.response.data.errors[Object.keys(error.response.data.errors)[0]]
                        message = message.toString();
                        this.$alert(message);
                    }
                });
            }
        }
    }
</script>


<style lang="scss" scoped>
.popup{
    width: 849px;
    margin: 0 auto;

    &__content{
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .row1{
        font-family: Montserrat;
        font-style: normal;
        font-weight: bold;
        font-size: 50px;
        line-height: 61px;
        text-align: center;
        color: #5C4998;
        margin-top: 60px;
    }

    .row2{
        font-family: Montserrat;
        font-style: normal;
        font-weight: normal;
        font-size: 30px;
        line-height: 37px;
        text-align: center;
        color: #5C4998;
        margin-top: 5px;
    }

    .row3{
        display: flex;
        flex-direction: column;

        input{
            width: 562px;
            height: 117px;
            margin-top: 25px;
            box-sizing: border-box;
            border-radius: 81px;
            border: 1px solid gray;
            font-size: 30px;
            line-height: 37px;
            font-style: normal;
            font-weight: normal;
            padding: 60px 40px;
        }
    }

    .row4{
        margin-top: 50px;
        font-style: normal;
        font-weight: bold;
        font-size: 36px;
        line-height: 44px;
        text-align: center;
        color: #5C4998;
    }

    .row5{
        margin-top: 17px;
        font-style: normal;
        font-weight: normal;
        font-size: 30px;
        line-height: 37px;
        text-align: center;
        color: #5C4998;
        width: 460px;
    }

    .row6{
        margin-bottom: 50px;
        a{
            width: 393.98px;
            height: 83.71px;
            font-family: Montserrat;
            font-style: normal;
            font-weight: normal;
            font-size: 27px;
            line-height: 75px;
            background: linear-gradient(89.77deg, #E164BE -0.56%, #FF74D8 -0.55%, #FF985E 97.67%);
            display: inline-block;
            text-align: center;
            text-decoration: none;
            border-radius: 50px;
            color: white;
            margin-top: 15px;
        }
    }

    textarea:focus, input:focus{
        outline: none;
    }
}
</style>