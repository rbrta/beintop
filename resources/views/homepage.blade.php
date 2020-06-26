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
                <a class="scrollTo" data-scroll="#tariffs">Выбрать тариф</a>
            </div>
        </section>
    </div>
    <!-- ------------------------------------------------------------------------------- -->
    <div class="wrapper-content">
        <section class="advantage">
            <div class="advantage-item" id="advantage">
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
                        Комплексную и автоматическую раскрутку instagram аккаунтов, сформированную в пакетах
                        позволяющая блогерам, рекламодателям, коммерческим аккаунтам и медийным личностям выходить
                        во все ТОП-ы(лента, Топ лучших публикаций) , и привлекать целевую и заинтересованную
                        аудиторию.
                    </div>
                </div>
            </div>
            <div class="advantage-item">
                <div class="advantage-text">
                    <div class="advantage-title">В чем удобства нашего cервиса для клиента?</div>
                    <div class="advantage-hr">
                    </div>
                    <div class="advantage-desc tal">
                        В автоматизации услуги и экономии времени! Приобретая тариф в нашем сервисе, вы получите автоматическую услугу, которая позволит сэкономить ваше личное время. Также за каждым клиентом у нас закрепляется личный персональный менеджер, с которым вы можете связаться 24/7 
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
<div id="app" class="container-middle">
    <div class="wrapper-content">
        <section class="tariffcontainer" >
            <div class="tariffcontainer-title" id="tariffs">
                Выберите Тариф
            </div>
            @foreach ($services as $tariff => $group_services)
            <div class="tariff-item item">
                <div class="item-title">
                    <div>Тарифы {{ $tariff }}</div>
                </div>
                <div class="item-body">

                <div class="glide {{$tariff}}">
                    <div class="glide__track" data-glide-el="track">
                        <ul class="glide__slides">
                            @foreach ($group_services as $service)
                                <li class="glide__slide">
                                <!-- slide element -->
                                <div class="tariff">
                                    <div class="module-border-wrap">
                                        <div class="tariff__body">
                                            <div class="row1">Тариф</div>
                                            <div class="row2">{{  $service->name }}</div>
                                            <div class="row3">{{  $service->periodindays }} дней</div>
                                            <div class="hr"></div>
                                            <div class="row4">- <span>{{ $service->likes }}</span> лайков на <span>{{ $service->posts }}</span> постов </div>
                                            <div class="row5">+ статистика (просмотры, охват и сохранения) </div>
                                            <div class="row6">
                                                - <span>{{ $service->views }} просмотров</span> <br>
                                                @if($service->igtv_unlim) 
                                                - <span class="ml">Видео и IGTV 
                                                    (<span class="unlimited">Безлимит <img src="/images/fire.svg" alt=""></span>)
                                                </span>
                                                @endif
                                            </div>

                                            @if(!is_null($service->bonus))
                                                <div class="row7"> + <img src="/images/bonus.svg" alt="">&nbsp;<span>Бонус</span> ({{ $service->bonus }})</div>
                                            @else
                                                <br><br>
                                            @endif

                                            <div class="row8">{{ str_replace('.00','',$service->price) }} рублей </div>
                                            <div class="row9">
                                                <button-activation :service="{{ $service }}" app_url="{{env('APP_URL')}}" shop_id="{{env('PAY_SHOP_ID')}}"></button-activation>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ### slide element ### -->
                                </li>
                            @endforeach
                        </ul>

                    </div>

                    <div class="glide__arrows" data-glide-el="controls">
                            <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fas fa-long-arrow-alt-left"></i></button>
                            <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fas fa-long-arrow-alt-right"></i></button>
                        </div>
                </div>
                </div>
            </div>
            @endforeach
        </section>
    </div>
    <popuploader idservice="{{$idService}}"></popuploader>
    <scrollto></scrollto>
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
                <div class="col__desc">Выберите тариф</div>
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
        <div class="row3" id="choosetariff">
            <a class="scrollTo" data-scroll="#tariffs">Выбрать тариф</a>
        </div>
    </div>
</div>


@endsection

@section('scripts')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glidejs@2.1.0/dist/css/glide.core.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glidejs@2.1.0/dist/css/glide.theme.min.css">
<script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>


<script>
    var sliderOptions = {
        type: 'carousel',
        startAt: 0,
        perView: 4,
        rewind: false,
        breakpoints: {
            1213: {
            perView: 3
            },
            995: {
            perView: 2
            },
            620: {
                perView: 1
            }
        }
    };

    var sliders = document.querySelectorAll('.glide');

    for (var i = 0; i < sliders.length; i++) {
        var glide = new Glide(sliders[i], sliderOptions);
        
        glide.mount();
    }

   

</script>


@endsection
