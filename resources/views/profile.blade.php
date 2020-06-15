@extends('layouts.simple')

@section('content')

@if(isset($type) && $type == 'password')
<form action="/userpanel/profile" id="signup-form" method="post">
    {{ csrf_field() }}
    <div class="login">
        <div class="wrapper">
            <div class="title">
                Изменить пароль
            </div>
            <div class="description">
                Здесь вы можете изменить свой пароль
            </div>
            <div class="inputs">
                <input type="hidden" name="action" value="password">
                <div class="intput-wrapper"><input name="password" placeholder="пароль" type="password" value=""></div>
                <div class="intput-wrapper"><input name="password_confirmation" placeholder="пароль еще раз" type="password" value=""></div>
            </div>
            <div>
                <button type="submit" class="login_btn">Сохранить</button>
            </div>

            @if(Session::has('saved'))
                <p style="text-align: center">Данные сохранены!</p>
            @endif

            @if($errors->any())
            <div class="errors">{{$errors->first()}}</div>
            @endif
            <div class="lost-password">
                <a href="/userpanel/profile">Вернуться в профиль</a>
            </div>
        </div>
    </div>
</form>

@else

<!-- ------------------------------------------------------------------------------- -->
<form action="/userpanel/profile" id="signup-form" method="post">
    {{ csrf_field() }}
    <div class="login">
        
        <div class="wrapper">
            <div class="title">
                Ваши данные
            </div>
            <div class="description">
                Здесь вы можете изменить свои персональные данные
            </div>
            <div class="inputs">
                <input type="hidden" name="action" value="updateProfile">
                <div class="intput-wrapper"><input name="email" placeholder="Email" type="email" value="{{$user->email}}"></div>
                <div class="intput-wrapper"><input name="full_name" placeholder="Полное Имя" type="text" value="{{$user->full_name}}"></div>
            </div>
            <div>
                <button type="submit" class="login_btn">Сохранить</button>
            </div>

            @if(Session::has('saved'))
                <p style="text-align: center">Данные сохранены!</p>
            @endif

            @if($errors->any())
            <div class="errors">{{$errors->first()}}</div>
            @endif
            <div class="lost-password">
                <a href="/userpanel/profile/password">Изменить пароль?</a>
            </div>
        </div>
    </div>
</form>
<!-- ------------------------------------------------------------------------------- -->

@endif

@endsection