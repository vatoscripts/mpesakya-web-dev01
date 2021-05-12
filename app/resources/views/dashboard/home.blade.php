@extends('layout.app')

@include('includes.dashboard.background')


@section('content')

    <section class="section-container">
        <!-- Page content-->
        <router-view></router-view>
        <vue-progress-bar></vue-progress-bar>
    </section>

@endsection





