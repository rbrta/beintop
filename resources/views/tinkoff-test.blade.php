@extends('layouts.auth')

@section('content')
<!-- ------------------------------------------------------------------------------- -->
<div class="login">
    <div class="wrapper">
        <div class="title">
            Оплата
        </div>
        <div class="description">
            Тест оплаты через Tinkoff
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tinkoff-test') }}" method="post">
            {{ csrf_field() }}
            <button class="login_btn" type="submit">Оплатить</button>
        </form>

        @if(request('Success') === 'true')
            <div style="margin-top: 30px">
                <p>Оплата прошла успешно</p>
                <a href="{{ route('tinkoff-test', ['cancel' => request('PaymentId')]) }}">Отменить оплату</a>
            </div>
        @endif

        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
</div>
<!-- ------------------------------------------------------------------------------- -->
@endsection