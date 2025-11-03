@extends('layouts.error')

@section('title', '500 - Server Error')
@section('code', '500')
@section('icon', '⚠️')

@section('title', 'Server Error')

@section('message')
    Something went wrong on our servers. We've been notified and are working to fix the issue.
@endsection

@section('actions')
    <a href="{{ url('/') }}" class="inline-block w-full sm:w-auto px-6 py-3 bg-white text-sky-500 font-semibold rounded-lg shadow-lg hover:bg-gray-100 transition-colors">
        Go Home
    </a>
    <a href="javascript:location.reload()" class="inline-block w-full sm:w-auto px-6 py-3 bg-white/10 text-white font-semibold rounded-lg border border-white/20 hover:bg-white/20 transition-colors">
        Try Again
    </a>
@endsection
