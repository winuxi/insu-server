@php
    $route = '#';

    if (auth()->check()) {
        $user = auth()->user();

        if ($user->hasRole(App\Models\User::ADMIN)) {
            $route = route('filament.admin.pages.themes');
        } elseif ($user->hasRole(App\Models\User::AGENT)) {
            $route = route('filament.agent.pages.themes');
        } elseif ($user->hasRole(App\Models\User::CUSTOMER)) {
            $route = route('filament.customer.pages.themes');
        } elseif ($user->hasRole(App\Models\User::SUPER_ADMIN)) {
            $route = route('filament.super-admin.pages.themes');
        }
    }
@endphp

<x-filament::link role="a" href="{{ $route }}" tooltip="Themes Settings">
    <x-heroicon-m-cog-6-tooth class="w-6 h-6" id="fullScreenIcon" />
</x-filament::link>
