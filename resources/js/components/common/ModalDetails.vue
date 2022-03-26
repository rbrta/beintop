<template>
<div class="popup">
    <div class="popup__tutle">
        <span>Insta:</span>
        {{ order.user.account_name }}
    </div>
    <div class="popup__service">
        <img src="/images/tmax.svg" alt />
    </div>
    <div class="popup__items">
        <div class="item1">
            <div class="likes">
                <div class="likes__amount">
                    <div>{{ order.service.likes }}</div>
                    <div>Лайков</div>
                </div>
                <div class="likes__posts">
                    На
                    <span>{{ order.service.posts }}</span> постов
                </div>
                <div class="likes__views">
                    <div class="val">{{ order.service.views }}</div> 
                    <div class="label">Просмотров</div>
                </div>
                <div class="likes__igtv">
                    На видео и IgTv
                    <br />(
                    <span>Безлимит</span>)
                </div>
                
            </div>
            <div class="blur"></div>
        </div>
        <div class="item2">
            <div class="bonus">
                <div class="bonus__comments">
                    <div>БОНУС</div>
                    <div>
                        <span>{{ order.service.bonus_comments }}</span> Комментариев
                    </div>
                    <div>
                        На
                        <span>{{ order.service.bonus_posts }}</span> постов в тему публикации
                    </div>
                </div>
                <div class="bonus__price">
                    <div>Стоимость</div>
                    <div>{{ order.service.price }}</div>
                    <div>руб/мес</div>
                </div>
            </div>
            <div class="bonus-img"></div>
        </div>
        <div class="item3">
            <div class="left">
                <div class="left__title">
                    <div>Осталось</div>
                    <div>{{ order.days }}</div>
                    <div>Дней</div>
                </div>
                <div class="left__timer">
                    <div>
                        <div>23</div>Часа
                    </div>
                    <div>
                        <div>:</div>
                    </div>
                    <div>
                        <div>12</div>Минут
                    </div>
                    <div>
                        <div>:</div>
                    </div>
                    <div>
                        <div>35</div>Секунд
                    </div>
                </div>
                <div style="display: none;" class="left__prolong">
                    <a href="#">Продлить</a>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ["order"]
};
</script>

<style lang="scss" scoped>
.likes {
    padding: 5px;
}

.popup {
    width: 1110px;
    height: 650px;
    margin: 0 auto;
    border-radius: 50px;
    padding: 10px 65px;

    &__tutle {
        color: #e73c8e;
        margin-top: 30px;
        font-size: 24px;
        line-height: 29px;

        span {
            font-weight: bold;
        }
    }

    &__service {
        margin-top: 35px;
    }

    &__items {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;

        .item1 {
            position: relative;
            width: 355px;

            .likes {
                color: white;
                margin: 5px;
                margin-top: 30px;
                text-align: center;
                position: relative;
                background: linear-gradient(121.36deg, #fb338d 4.1%, #ff6b40 98.03%);
                border-radius: 39px;

                &__amount {
                    font-weight: 900;
                    font-size: 48px;
                    line-height: 116.7%;
                }

                &__posts {
                    font-weight: normal;
                    margin-top: 5px;

                    span {
                        font-weight: bold;
                    }
                }

                &__views {
                    font-weight: 900;
                    font-size: 38px;
                    line-height: 116.7%;
                    margin-top: 40px;
                }

                &__igtv {
                    span {
                        color: rgb(255, 208, 57);
                        font-weight: bold;
                    }
                }

                &__change {
                    position: absolute;
                    left: 0;
                    right: 0;

                    a {
                        color: #eb5b9c;
                        display: inline-block;
                        width: 310.4px;
                        height: 53px;
                        background: #ffffff;
                        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.23);
                        border-radius: 39px;

                        font-weight: bold;
                        font-size: 20px;
                        line-height: 50px;
                        text-decoration: none;
                    }
                }
            }

            .blur {
                position: absolute;
                color: red;
                top: 0px;
                width: 100%;
                height: 100%;
                border-radius: 39px;
                background: linear-gradient(121.36deg, #fb338d 4.1%, #ff6b40 98.03%);
                z-index: -1000;
                filter: blur(4px);
            }
        }

        .item2 {
            position: relative;

            .bonus {
                width: 245px;
                text-align: center;
                color: #fc407b;

                &__comments {
                    border: 4px solid #fc407b;
                    height: 202px;
                    border-radius: 17px;

                    span {
                        font-weight: 900;
                        color: #fc407b;
                    }

                    div:nth-of-type(1) {
                        font-weight: 900;
                        font-size: 48px;
                        margin-top: 38px;
                    }

                    div:nth-of-type(2) {
                        font-size: 18px;
                        line-height: 116.7%;
                        color: #5c4998;
                    }

                    div:nth-of-type(3) {
                        margin-top: 15px;
                        font-size: 18px;
                        line-height: 116.7%;
                        color: #5c4998;
                    }
                }

                &__price {
                    div:nth-of-type(1) {
                        color: #5c4998;
                        font-weight: 900;
                        font-size: 33px;
                        line-height: 40px;
                        margin-top: 22px;
                    }

                    div:nth-of-type(2) {
                        color: #29171d;
                        font-weight: 700;
                        font-size: 33px;
                        line-height: 40px;
                    }

                    div:nth-of-type(3) {
                        font-size: 17px;
                        color: #29171d;
                    }

                    div:nth-of-type(4) {
                        color: #150f26;
                        font-size: 12px;
                        color: gray;
                        text-align: center;
                        margin-top: 6px;

                        span {
                            box-shadow: 1px 1px 7px rgba(0, 0, 0, 0.3);
                            border-radius: 11px;
                            padding: 4px 6px;

                            img {
                                position: relative;
                                top: 3px;
                            }
                        }
                    }
                }
            }

            .bonus-img {
                position: absolute;
                top: -22px;
                text-align: center;
                width: 100%;
            }
        }

        .item3 {
            .left {
                width: 263px;
                text-align: center;

                &__title {
                    div:nth-of-type(1) {
                        font-weight: 900;
                        font-size: 36px;
                        line-height: 14px;
                        text-transform: uppercase;
                        color: #9a4696;
                    }

                    div:nth-of-type(2) {
                        font-weight: 900;
                        font-size: 96px;
                        text-transform: uppercase;
                        color: #9a4696;
                        margin-top: 10px;
                    }

                    div:nth-of-type(3) {
                        font-size: 30px;
                        color: #5c4998;
                        font-weight: 600;
                        margin-top: -28px;
                    }
                }

                &__timer {
                    margin-top: 16px;
                    font-size: 14px;
                    display: flex;
                    justify-content: center;
                    color: #5c4998;

                    div div {
                        font-weight: bold;
                        font-size: 36px;
                        color: #29171d;
                        border-radius: 19px;
                        border: 2px solid #5c4998;
                        padding: 7px;
                        margin-bottom: 8px;
                    }

                    div:nth-of-type(even) div {
                        border: 0px;
                    }
                }

                &__prolong {
                    margin-top: 15px;

                    a {
                        background: linear-gradient(89.76deg,
                                #e164be -0.56%,
                                #ff74d8 -0.55%,
                                #ff985e 97.67%);
                        border-radius: 50px;
                        color: white;
                        text-decoration: none;
                        width: 263px;
                        height: 54px;
                        text-align: center;
                        display: inline-block;
                        font-size: 24px;
                        line-height: 54px;
                        box-shadow: 0 0 15px #e164be;
                    }
                }
            }
        }
    }
}
</style>
