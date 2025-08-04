@extends('layouts.dashboard')
@section('title', 'Dashboard')

@section('content')
<!-- Welcome Card -->
<div class="dashboard-card welcome-card">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1>Welcome Back, {{ Auth::user()->name }}!</h1>
            <p class="mb-0">Here's what's happening with your learning platform today.</p>
        </div>
        <div class="col-md-4 text-end">
            <i class="fas fa-chart-line" style="font-size: 4rem; opacity: 0.3;"></i>
        </div>
    </div>
</div>
@endsection
