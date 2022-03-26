@extends('layouts.auth')

@section('content')
    <form action="{{ route('manager.signup') }}" id="signup-manager-form" method="post">
        {{ csrf_field() }}
        <div class="login">
            <div class="wrapper">
                <div class="title">
                    Подверждение аккаунта менеджера
                </div>
                <div class="description">
                    Заполните, пожалуйста, все пустые поля
                </div>
                <div class="inputs">
                    <input type="hidden" name="action" value="signup">
                    <input type="hidden" name="email" value="{{$email}}">
                    <div class="intput-wrapper"><input name="full_name" placeholder="Полное имя" type="text"></div>
                    <div class="intput-wrapper"><input name="_email" placeholder="Email" type="text" value="{{$email}}" disabled></div>
                    <div class="intput-wrapper"><input name="password" placeholder="Пароль" type="password" value=""></div>
                    <div class="intput-wrapper"><input name="password_confirmation" placeholder="Пароль еще раз" type="password" value=""></div>
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
                
            </div>
        </div>
    </form>

@endsection