@if ($panelId == 'super-admin' || $panelId == 'admin')
    <div class="flex items-center gap-4">
        <a href="{{ url('/') }}" class="flex items-center gap-4">
            <img src="{{ appLogo() }}" alt="{{ appName() }}" width="50" height="50">
        </a>
    </div>
@else
    <div class="flex items-center gap-4">
        <a href="{{ url('/') }}">
            <div class="fi-logo flex text-xl font-bold leading-5 tracking-tight text-gray-950 dark:text-white">
                {{ appNameByAdmin() }}
            </div>
        </a>
    </div>
@endif
