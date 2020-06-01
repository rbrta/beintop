@extends('layouts.master')

@section('content')
<div class="container-top">
    <div class="wrapper-content promotion-wrapper">
        <div class="rocket">
        </div>

        <section class="promotion">
            <div class="promotion-title">
                Раскрутка вашего Instagram аккаунта
            </div>
            <div class="promotion-desc">
                Сервис по доходу комплексной и автоматической активности
            </div>
            <div class="promotion-btn">
                <a href="#">Выбрать тариф</a>
            </div>
        </section>
    </div>
    <!-- ------------------------------------------------------------------------------- -->
    <div class="wrapper-content">
        <section class="advantage">
            <div class="advantage-item">
                <div class="advantage-img">
                    <img src="/images/phone.svg" alt="">
                </div>
                <div class="advantage-text">
                    <div class="advantage-title">
                        Что мы предоставляем клиентам?
                    </div>
                    <div class="advantage-hr">
                    </div>
                    <div class="advantage-desc tar">
                        Комплексную и автоматическую раскрутку instsgram аккаунтов, сформированную в пакетах
                        позволяющая блогерам, рекламодателям, коммерческим аккаунтам и медийным личностям выходить
                        во все ТОП-ы(лента, Топ лучших публикаций) , и привлекать целевую и заинтересованную
                        аудиторию.
                    </div>
                </div>
            </div>
            <div class="advantage-item">
                <div class="advantage-text">
                    <div class="advantage-title">
                        Что мы предоставляем клиентам?
                    </div>
                    <div class="advantage-hr">
                    </div>
                    <div class="advantage-desc tal">
                        Комплексную и автоматическую раскрутку instsgram аккаунтов, сформированную в пакетах
                        позволяющая блогерам, рекламодателям, коммерческим аккаунтам и медийным личностям выходить
                        во все ТОП-ы(лента, Топ лучших публикаций) , и привлекать целевую и заинтересованную
                        аудиторию.
                    </div>
                </div>
                <div class="advantage-img">
                    <img src="/images/clock.svg" alt="">
                </div>
            </div>
        </section>
    </div>
</div>

<!-- ------------------------------------------------------------------------------- -->
<div class="container-middle">
    <div class="wrapper-content">
        <section class="tariffcontainer">
            <div class="tariffcontainer-title">
                Выберите Тариф
            </div>
            @foreach ($services as $tariff => $group_services)
            <div class="tariff-item item">
                <div class="item-title">
                    <div>{{ $tariff }}</div>
                </div>
                <div class="item-body">
                    @foreach ($group_services as $service)
                    <div class="tariff">
                        <div class="module-border-wrap">
                            <div class="tariff__body">
                                <div class="row1">Тариф</div>
                                <div class="row2">{{  $service->name }}</div>
                                <div class="row3">{{  $service->periodindays }} дней</div>
                                <div class="hr"></div>
                                <div class="row4">- <span>{{ $service->likes }}</span> лайков на <span>{{ $service->posts }}</span> постов </div>
                                <div class="row5">+ статистика (просмотры и охват) </div>
                                <div class="row6">
                                    - <span>{{ $service->views }} просмотров</span> <br>
                                        <span class="ml">На видео и IGTV 
                                            @if($service->igtv_unlim) 
                                                (<span class="unlimited">Безлимит <img src="/images/fire.svg" alt=""></span>)
                                            @endif
                                        </span>
                                </div>
                                <div class="row7"> + <img src="/images/bonus.svg"
                                        alt="">&nbsp;<span>Бонус</span> (<span>{{ $service->bonus_comments }}</span> комментариев на
                                    <span>{{ $service->bonus_posts }}</span> постов в тему публикации)</div>
                                <div class="row8">{{ str_replace('.00','',$service->price) }} рублей </div>
                                <div class="row9">
                                    <a href="#">активировать</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </section>
    </div>
</div>
<!-- ------------------------------------------------------------------------------- -->
<div class="container-below">
    <div class="row1">
        <span>Как это работает?</span>
    </div>
    <div class="row2">
        <div class="content">
            <div class="col col1">
                <div class="col__title"><img src="/images/digital.svg" alt=""></div>
                <div class="col__desc">Веберите тариф</div>
            </div>
            <div class="col arrow col2">
                <!-- <img src="./assets/images/arrow.svg" alt=""> -->
            </div>
            <div class="col col3">
                <div class="col__title"><img src="./images/pay-card.svg" alt=""></div>
                <div class="col__desc">
                    Нажмите “Заказать” и перейдите к оплате
                </div>
            </div>
            <div class="col arrow col4">
                <!-- <img src="./assets/images/arrow.svg" alt=""> -->
            </div>
            <div class="col col5">
                <div class="col__title"><img src="/images/love.svg" alt=""></div>
                <div class="col__desc">
                    Убедитесь в качестве работы и наслаждайтесь результатом
                </div>
            </div>
            <div>
            </div>
        </div>
        <div class="row3">
            <a href="#">Выбрать тариф</a>
        </div>
    </div>
</div>
@endsection