@extends('layouts.admin')

@section('content')

<div class="main-block">

    <div class="wrapper-content admin">

        <div class="content-table">
            <admin-managers-table :items='@json($items)'></admin-managers-table>
        </div>
    </div>

</div>
@endsection