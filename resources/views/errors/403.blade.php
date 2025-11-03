@extends('layouts.error')

@section('title', '403 - Access Forbidden')
@section('code', '403')
@section('icon', '🔒')

@section('title', 'Access Forbidden')

@section('message')
    You don't have permission to access this resource. Please contact an administrator if you believe this is an error.
@endsection

@section('actions')
    <a href="{{ url('/') }}" class="inline-block w-full sm:w-auto px-6 py-3 bg-white text-sky-500 font-semibold rounded-lg shadow-lg hover:bg-gray-100 transition-colors">
        Go Home
    </a>
    @guest
        <a href="{{ route('login') }}" class="inline-block w-full sm:w-auto px-6 py-3 bg-white/10 text-white font-semibold rounded-lg border border-white/20 hover:bg-white/20 transition-colors">
            Login
        </a>
    @else
        <a href="{{ route('dashboard') }}" class="inline-block w-full sm:w-auto px-6 py-3 bg-white/10 text-white font-semibold rounded-lg border border-white/20 hover:bg-white/20 transition-colors">
            Dashboard
        </a>
    @endguest
@endsection
