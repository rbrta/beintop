<template>
    <div class="details-panel">
        <div class="account-name" v-if="mode != 'newOrder'" ><b>Insta:</b> {{ user.full_name }}</div>
        <h1 class="tariff_name">Тариф {{ service.category.name }}</h1>

        <div class="flex">
            <div class="left">
                <div class="likes">{{ service.likes }}</div>
                <div class="lakes_label">Лайков</div>
                <div class="likes_posts">На <b>{{ service.posts }}</b> постов</div>

                <div class="views">{{ service.views }}</div>
                <div class="views_label">Просмотров</div>

                <div class="igtv_label" v-if="service.igtv_unlim">На видео и IGTV</div>
                <div class="igtv_label_unlim" v-if="service.igtv_unlim">(<span>Безлимит</span><div class="fire"></div>)</div>
            </div>

            <div class="center">
                <div class="bonus">
                    <div class="bonus__img"></div>
                    <div class="bonus__title">Бонус</div>
                    <div class="bonus__comments"><b>{{ service.bonus_comments }}</b> комментариев</div>

                    <div class="bonus__posts">На <b>{{ service.bonus_posts }}</b> постов <br> в тему публикации</div>
                </div>

                <div class="price__label">Стоимость</div>
                <div class="price">{{ service.price_formatted }}</div>
                <div class="price__currency">руб.мес</div>
            </div>

            <div class="right">
                <countdown :time="countdownTo" :interval="1000" v-if="expirationDate">
                    <template slot-scope="props">
                        <div class="expires">
                            <div class="expires__label">Осталось</div>
                            <div class="expires__days_count">{{ props.days }}</div>
                            <div class="expires__days">{{ $plur(props.days, $plurString.days)}}</div>

                            <div class="expires__timer">
                                <div class="value">{{ props.hours }} <span>{{ $plur(props.hours, $plurString.hours) }} </span></div>
                                <div class="delimeter">:</div>
                                <div class="value">{{ props.minutes }} <span>{{ $plur(props.minutes, $plurString.minutes) }}</span></div>
                                <div class="delimeter">:</div>
                                <div class="value">{{ props.seconds }} <span>{{ $plur(props.seconds, $plurString.seconds) }}</span></div>
                            </div>
                        </div>
                    </template>
                </countdown>
                <div v-else class="expires">
                    <div class="expires__label">Период</div>
                    <div class="expires__days_count">{{service.periodindays}}</div>
                    <div class="expires__days">Дней</div>
                </div>

                <button-activation v-if="mode === 'newOrder'" :user="user" :service="service" mode="fromUserpanel"></button-activation>
            </div>
        </div>
    </div>
</template>

<script>
    import buttonActivation from '../common/ButtonActivation';

    export default {
        name: "ServiceDetails",
        props: ['service', 'expirationDate', 'user', 'mode'],
        components: {'button-activation': buttonActivation},


        computed: {
            countdownTo() {
                let expDate = new Date(this.expirationDate).getTime();
                let nowDate = new Date().getTime();

                return Math.abs(nowDate - expDate)
            }
        },
    }
</script>
