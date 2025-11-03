@extends('layouts.error')

@section('title', '503 - Service Unavailable')
@section('code', '503')
@section('icon', '🔧')

@section('title', 'Service Unavailable')

@section('message')
    We're temporarily down for maintenance. Please check back in a few minutes.
@endsection

@section('actions')
    <a href="javascript:location.reload()" class="inline-block w-full sm:w-auto px-6 py-3 bg-white text-sky-500 font-semibold rounded-lg shadow-lg hover:bg-gray-100 transition-colors">
        Refresh Page
    </a>
    <a href="{{ url('/') }}" class="inline-block w-full sm:w-auto px-6 py-3 bg-white/10 text-white font-semibold rounded-lg border border-white/20 hover:bg-white/20 transition-colors">
        Go Home
    </a>
@endsection
