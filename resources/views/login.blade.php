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
    <form action="signup" id="signup-form" method="post">
    {{ csrf_field() }}
    <div class="login">
        <div class="wrapper">
            <div class="title">
                Авторизация
            </div>
            <div class="description">
                Для входа в личный кабинет необходимо ввести логин и пароль
            </div>
            <div class="inputs">
                <div class="intput-wrapper"><input name="email" placeholder="Email" type="email" ></div>
                <div class="intput-wrapper"><input name="password" placeholder="Пароль" type="password"></div>
            </div>
            <div>
                <a href="#" class="login_btn" onclick="document.getElementById('signup-form').submit(); return false;">
                    Авторизоваться
                </a>
            </div>
            @if($errors->any())
                <div class="errors">{{$errors->first()}}</div>
            @endif
            <div class="lost-password">
                <a href="/password/reset">Забыли пароль?</a>
            </div>
        </div>
    </div>
    </form>
    <!-- ------------------------------------------------------------------------------- --> 
</div>
<style>
.login{
    margin-top: 126px;
    max-width: 779px;
    padding: 10px;
    margin: 126px auto 0px auto;
    border-radius: 35px;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.25);
    background-color: white;
}
.login .wrapper{
    max-width: 483px;
    background-color: white;
    margin: 0 auto;
    text-align: center;
    padding: 0px 5px;
}
.login .wrapper .title{
    color: #984493;
    font-size: 42px;
    padding-top: 60px;
}
@media(max-width:600px) {
    .login .wrapper .title{
        font-size: 32px;
        line-height: 1;
    }
}
.login .wrapper .description{
    font-size: 18px;
    line-height: 22px;
    max-width: 381px;
    color: #984493;
    margin: 0 auto;
    text-align: center;
    padding-top: 12px;
}
.login .inputs input{
    display: block;
    width: 100%;
    height: 68px;
    margin-top: 1rem;
    box-sizing: border-box;
    border-radius: 81px;
    border: 1px solid gray;
    font-size: 25px;
    font-style: normal;
    font-weight: normal;
    padding: 20px 40px;
}
.login .wrapper a.login_btn{
    width: 100%;
    height: 68px;
    background: linear-gradient(89.67deg, #E164BE -0.56%, #FF74D8 -0.55%, #FF985E 97.67%);
    border-radius: 50px;
    display: inline-block;
    margin-top: 26px;
    color: white;
    text-decoration: none;
    line-height: 2.7 !important;
    font-size: 25px;
    line-height: 30px;
   
}
.login .lost-password{
    text-align: right;
    color: #984493;
    font-size: 18px;
    margin-top: 26px;
    padding-bottom: 63px;
}
.login .lost-password a{
    color: #984493;
    text-decoration: none;
}
input:focus{
    outline: none;
}
.errors{
    margin-top: 5px;
    color: #eb4e63;
    font-weight: bold;
    font-size: 20px;
}
</style>
<script src="/js/main.js"></script>
<script src="/js/app.js"></script>
</body>
</html>