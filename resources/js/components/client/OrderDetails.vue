<template>
    <div class="details-panel">
        <div class="account-name"><b>Insta:</b> {{ data.account_name }}</div>
        <h1 class="tariff_name">Тариф Max</h1>

        <div class="flex">
            <div class="left">
                <div class="likes">{{ data.service.likes }}</div>
                <div class="lakes_label">Лайков</div>
                <div class="likes_posts">На <b>{{ data.service.posts }}</b> постов</div>

                <div class="views">{{ data.service.views }}</div>
                <div class="views_label">Просмотров</div>

                <div class="igtv_label" v-if="data.service.igtv_unlim">На видео и IGTV</div>
                <div class="igtv_label_unlim" v-if="data.service.igtv_unlim">(<span>Безлимит</span><div class="fire"></div>)</div>
            </div>

            <div class="center">
                <div class="bonus">
                    <div class="bonus__img"></div>
                    <div class="bonus__title">Бонус</div>
                    <div class="bonus__comments"><b>{{ data.service.bonus_comments }}</b> комментариев</div>

                    <div class="bonus__posts">На <b>{{ data.service.bonus_posts }}</b> постов <br> в тему публикации</div>
                </div>

                <div class="price__label">Стоимость</div>
                <div class="price">{{ data.service.price }}</div>
                <div class="price__currency">руб.мес</div>
            </div>

            <div class="right">
                <countdown :time="countdownTo" :interval="1000">
                    <template slot-scope="props">
                        <div class="expires">
                            <div class="expires__label">Осталось</div>
                            <div class="expires__days_count">{{ props.days }}</div>
                            <div class="expires__days">Дней</div>

                            <div class="expires__timer">
                                <div class="value">{{ props.hours }} <span>Часа</span></div>
                                <div class="delimeter">:</div>
                                <div class="value">{{ props.minutes }} <span>Минут</span></div>
                                <div class="delimeter">:</div>
                                <div class="value">{{ props.seconds }} <span>Секунд</span></div>
                            </div>
                        </div>
                    </template>
                </countdown>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ClientOrderDetails",
        props: ['data'],

        computed: {
            countdownTo() {
                let expDate = new Date(this.data.expiration_date).getTime();
                let nowDate = new Date().getTime();

                return Math.abs(nowDate - expDate)
            }
        },
    }
</script>
