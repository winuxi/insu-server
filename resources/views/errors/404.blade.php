@extends('layouts.error')

@section('title', '404 - Page Not Found')
@section('code', '404')
@section('icon', '🔍')

@section('title', 'Page Not Found')

@section('message')
    The page you're looking for doesn't exist. It might have been moved, deleted, or you entered the wrong URL.
@endsection

@section('actions')
    <a href="{{ url('/') }}" class="inline-block w-full sm:w-auto px-6 py-3 bg-white text-sky-500 font-semibold rounded-lg shadow-lg hover:bg-gray-100 transition-colors">
        Go Home
    </a>
    <a href="javascript:history.back()" class="inline-block w-full sm:w-auto px-6 py-3 bg-white/10 text-white font-semibold rounded-lg border border-white/20 hover:bg-white/20 transition-colors">
        Go Back
    </a>
@endsection
