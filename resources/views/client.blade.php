@extends('layouts.panel')

@section('content')

<div class="main-block">
        
        <div class="container-top">
            <div class="wrapper-content">
                <div class="row1">
                    <b>Аккаунт:</b> {{ $user->email }}
                </div>
                <div class="row2 hide">
                    <a href="/logout">Сменить аккаунт</a>
                </div>
            </div>
        </div>
        <!-- ------------------------------------------------------------------------------- -->

        <div class="wrapper-content">
            <div class="content-table">
                <ul class="tabs">
                    <li>Активные</li>
                    <li>Архивные</li>
                    <li>Добавить</li>
                </ul>

                <div class="table-wrapper hide">
                    <table>
                        <thead>
                            <tr>
                                <th>Услуга</th>
                                <th>Аккаунт</th>
                                <th>Дата окончания</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="Услуга"><div class="text-big">Тариф Max</div><div class="text-large">1000</div></td>
                                <td data-label="Аккаунт"><div class="text-default">instagram</div></td>
                                <td data-label="Дата окончания"><div class="text-big">10 апреля 2020</div><div class="text-small">осталось 15 дней</div></td>
                                <td data-label="Действия"><span class="btn">Детали</span></td>
                            </tr>
                            <tr>
                                <td data-label="Услуга"><div class="text-big">Тариф Max</div><div class="text-large">1000</div></td>
                                <td data-label="Аккаунт"><div class="text-default">instagram</div></td>
                                <td data-label="Дата окончания"><div class="text-big">10 апреля 2020</div><div class="text-small">осталось 15 дней</div></td>
                                <td data-label="Действия"><span class="btn">Детали</span></td>
                            </tr>
                            <tr>
                                <td data-label="Услуга"><div class="text-big">Тариф Max</div><div class="text-large">1000</div></td>
                                <td data-label="Аккаунт"><div class="text-default">instagram</div></td>
                                <td data-label="Дата окончания"><div class="text-big">10 апреля 2020</div><div class="text-small">осталось 15 дней</div></td>
                                <td data-label="Действия"><span class="btn">Детали</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="details-panel">
                    <div class="account-name"><b>Insta:</b> login</div>
                    <h1 class="tariff_name">Тариф Max</h1>

                    <div class="flex">
                        <div class="left">
                            <div class="likes">8000</div>
                            <div class="lakes_label">Лайков</div>
                            <div class="likes_posts">На <b>30</b> постов</div>

                            <div class="views">30000</div>
                            <div class="views_label">Просмотров</div>

                            <div class="igtv_label">На видео и IGTV</div>
                            <div class="igtv_label_unlim">(<span>Безлимит</span><div class="fire"></div>)</div>
                        </div>

                        <div class="center">
                            <div class="bonus">
                                <div class="bonus__img"></div>
                                <div class="bonus__title">Бонус</div>
                                <div class="bonus__comments"><b>25-30</b> комментариев</div>

                                <div class="bonus__posts">На <b>5</b> постов <br> в тему публикации</div>
                            </div>

                            <div class="price__label">Стоимость</div>
                            <div class="price">25 990</div>
                            <div class="price__currency">руб.мес</div>
                        </div>

                        <div class="right">
                            <div class="expires">
                                <div class="expires__label">Осталось</div>
                                <div class="expires__days_count">30</div>
                                <div class="expires__days">Дней</div>

                                <div class="expires__timer">
                                    <div class="value">23 <span>Часа</span></div>
                                    <div class="delimeter">:</div>
                                    <div class="value">12 <span>Минут</span></div>
                                    <div class="delimeter">:</div>
                                    <div class="value">35 <span>Секунд</span></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>  

@endsection