@extends('layouts.admin')

@section('content')

<div class="main-block">

    <div class="wrapper-content admin">

        <div class="content-table">
            <admin-service-table :items='@json($services)'></admin-service-table>
        </div>
    </div>

</div>
@endsection