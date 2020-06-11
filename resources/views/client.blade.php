@extends('layouts.panel')

@section('content')

<div class="main-block">

        <div class="container-top">
            <div class="wrapper-content">
                <div class="row1">
                    <b>Аккаунт:</b> {{ $user->email }}
                </div>
                <div class="row2 hide">
                    <a href="/logout">Сменить аккаунт</a>
                </div>
            </div>
        </div>
        <!-- ------------------------------------------------------------------------------- -->

        <div class="wrapper-content">
            <client-area :orders='@json($orders)' :services='@json($services)'></client-area>
        </div>
</div>

@endsection
