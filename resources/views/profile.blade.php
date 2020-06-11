@extends('layouts.simple')

@section('content')
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
                <div class="intput-wrapper"><input name="name" placeholder="Полное Имя" type="text" value="{{$user->name}}"></div>
            </div>
            <div>
                <a href="#" class="login_btn" onclick="document.getElementById('signup-form').submit(); return false;">
                    Сохранить
                </a>
            </div>
            @if($errors->any())
            <div class="errors">{{$errors->first()}}</div>
            @endif
            <div class="lost-password">
                <a href="#">Изменить пароль?</a>
            </div>
        </div>
    </div>
</form>
<!-- ------------------------------------------------------------------------------- -->
@endsection