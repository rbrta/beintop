@extends('layouts.auth')
@section('content')
    <!-- ------------------------------------------------------------------------------- --> 
    <form method="POST" id="signup-form" action="{{ route('password.email') }}">
        @csrf

        <div class="login">
        <div class="wrapper">
        
            <div class="title">
                Восстановлениe пароля
            </div>
            <div class="description">
                Для восстановления пароля необходимо ввести email
            </div>

            <div class="inputs">
                <div class="intput-wrapper">
                    <input id="email" placeholder="Email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
            </div>

            <div>
                <a href="#" class="login_btn" onclick="document.getElementById('signup-form').submit(); return false;">
                    Восстановить пароль
                </a>
            </div>
            @if (session('status'))
                <div class="alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if($errors->any())
                <div class="errors">{{$errors->first()}}</div>
            @endif
            <div class="lost-password">
            </div>

        </div>
        </div>

    </form>
    <!-- ------------------------------------------------------------------------------- --> 
@endsection