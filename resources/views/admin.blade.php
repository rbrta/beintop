@extends('layouts.admin')

@section('content')

<div class="main-block">

    <div class="wrapper-content admin">

        <div class="content-table">
            <service-table :items='@json($services)'></service-table>
        </div>
    </div>

</div>
@endsection