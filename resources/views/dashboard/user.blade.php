@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>User Dashboard</h1>
    <p>Selamat datang, {{ Auth::user()->name }}! Kamu login sebagai <strong>User</strong>.</p>
    <a href="{{ route('logout') }}" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
       Logout
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
@endsection
