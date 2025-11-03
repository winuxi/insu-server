@extends('layouts.error')

@section('title', '419 - Session Expired')
@section('code', '419')
@section('icon', '⏰')

@section('title', 'Session Expired')

@section('message')
    Your session has expired for security reasons. Please refresh the page and try again.
@endsection

@section('actions')
    <a href="javascript:location.reload()" class="inline-block w-full sm:w-auto px-6 py-3 bg-white text-sky-500 font-semibold rounded-lg shadow-lg hover:bg-gray-100 transition-colors">
        Refresh Page
    </a>
    <a href="{{ url('/') }}" class="inline-block w-full sm:w-auto px-6 py-3 bg-white/10 text-white font-semibold rounded-lg border border-white/20 hover:bg-white/20 transition-colors">
        Go Home
    </a>
@endsection
