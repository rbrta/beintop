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
    <form method="POST" id="signup-form" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="login">
        <div class="wrapper">
        
            <div class="title">
                Восстановления пароля
            </div>

            <div class="inputs">
                <div class="intput-wrapper">
                    <input id="email" placeholder="Email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                </div>
                <div class="intput-wrapper">
                    <input id="password" type="password" placeholder="Новый пароль" class="form-control @error('email') is-invalid @enderror" name="password" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
                <div class="intput-wrapper">
                    <input id="password" type="password" placeholder="Новый пароль еще раз" class="form-control @error('email') is-invalid @enderror" name="password_confirmation" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            </div>

            <div>
                <a href="#" class="login" onclick="document.getElementById('signup-form').submit(); return false;">
                    Восстановить пароль
                </a>
            </div>
            @if($errors->any())
                <div class="errors">{{$errors->first()}}</div>
            @endif
            <div class="lost-password">
            </div>

        </div>
        </div>

    </form>
    <!-- ------------------------------------------------------------------------------- --> 
</div>
<style>
.login{
    margin-top: 126px;
    width: 779px;
    margin: 126px auto 0px auto;
    border-radius: 35px;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.25);
    background-color: white;
}
.login .wrapper{
    width: 483px;
    background-color: white;
    margin: 0 auto;
    text-align: center;
}
.login .wrapper .title{
    color: #984493;
    font-size: 42px;
    padding-top: 60px;
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
.login .wrapper a.login{
    width: 483px;
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