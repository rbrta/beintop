@extends('layouts.auth')

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
                <button class="login_btn" type="submit">
                    Авторизоваться
                </button>
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