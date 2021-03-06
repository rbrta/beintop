<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оплата не завершена</title>
    <link rel="stylesheet" href="{{ asset('/css/backendpage.css') }}">
</head>
<body>
<div id="app" >
    <!-- ------------------------------------------------------------------------------- -->    
     @include('parts.header', ['type' => 'auth'])
    <!-- ------------------------------------------------------------------------------- --> 
    <div class="payment-message">
        <div class="wrapper">
            <div class="title">
                Оплата не завершена
            </div>
            @if(request('Message'))
                <div>{{ request('Message') }} </div>
            @endif
            <div>
                <a href="/userpanel">Перейти в  кабинет</a>
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