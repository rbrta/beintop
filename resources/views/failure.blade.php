<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('/css/backendpage.css') }}">
</head>
<body>
<div id="app" >
     <!-- ------------------------------------------------------------------------------- -->    
     <header >
        <div class="wrapper">
            <div class="logo">
                <img src="/images/logo.svg" alt="">
                <span>Be-in-top</span>
            </div>
            <ul class="menu">
                <li><i class="fas fa-star"></i> <a href="#">Наши преимущества</a></li>
                <li><i class="fas fa-th"></i> <a href="#">Выбрать тариф</a></li>
                <li><i class="fas fa-home"></i> <a href="#">На главную</a></li>
                <li><i class="fas fa-user"></i> <a href="#">Личный кабинет</a></li>
            </ul>

            <div id="menuBtn" class="mobile-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>
    <!-- ------------------------------------------------------------------------------- --> 
    <div class="payment-message">
        <div class="wrapper">
            <div class="title">
                Оплата не завершена
            </div>
            <div>
                <a href="/client">Перейти в  кабинет</a>
            </div>
        </div>
    </div>
    <!-- ------------------------------------------------------------------------------- --> 
</div>
<style>
.payment-message{
    margin-top: 126px;
}
.payment-message .wrapper{
    width: 1251px;
    height: 342px;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.25);
    background-color: white;
    margin: 0 auto;
    border-radius: 35px;
    text-align: center;
}
.payment-message .wrapper .title{
    font-size: 42px;
    color: #984493;
    padding-top: 79px;
}
.payment-message .wrapper a{
    width: 315px;
    height: 47px;
    background: linear-gradient(89.67deg, #E164BE -0.56%, #FF74D8 -0.55%, #FF985E 97.67%);
    border-radius: 50px;
    font-size: 20px;
    display: inline-block;
    margin-top: 63px;
    color: white;
    text-decoration: none;
    line-height: 2.2
}
</style>
<script src="/js/main.js"></script>
<script src="/js/app.js"></script>
</body>
</html>