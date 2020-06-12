@extends('layouts.simple')

@section('content')
<!-- ------------------------------------------------------------------------------- -->
<form action="{{ route('login') }}" id="signup-form" method="post">
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
                <div class="intput-wrapper"><input name="email" placeholder="Email" type="email"></div>
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
@endsection