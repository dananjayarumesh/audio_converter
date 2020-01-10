@extends('layouts.app')

@section('content')
<app-header></app-header>

<main class="py-4">
    <router-view></router-view>
</main>

<!-- <app-footer></app-footer> -->
@endsection