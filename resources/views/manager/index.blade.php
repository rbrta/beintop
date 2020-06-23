@extends('layouts.manager')

@section('content')

<div class="main-block">

    <div class="wrapper-content admin">

        <div class="content-table">
            <manager-service-table :items='@json($services)' :managerid='{{$userid}}'></manager-service-table>
        </div>

    </div>

</div>
    
@endsection