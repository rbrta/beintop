@extends('layouts.manager')

@section('content')

<div class="main-block">

    <div class="wrapper-content admin">

        <div class="content-table">
            <manager-clients-table :items='@json($clients)'></manager-clients-table>
        </div>

    </div>

</div>
    
@endsection