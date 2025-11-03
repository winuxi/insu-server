<div class="w-full h-full">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var url = document.getElementById('bg-image').getAttribute('data-url');
            var bgImageDiv = document.createElement('div');
            bgImageDiv.classList.add('bg-image');

            var img = document.createElement('img');
            img.src = url;
            img.alt = '';

            bgImageDiv.appendChild(img);
            document.body.prepend(bgImageDiv);
        });

        document.addEventListener('DOMContentLoaded', function() {
            var elements = document.querySelectorAll('.fls-display-on');
            elements.forEach(function(element) {
                element.style.right = '0';
            });
        });
    </script>

    @vite('resources/css/login.css')
    <div id="bg-image" data-url="{{ authBgImage() ?? asset('images/auth-bg.jpg') }}"></div>

    <div class="login-container">
        <div class="logo-image">
            <a href="/">
                <img src="{{ appLogo() }}" alt="{{ appName() }}">
            </a>
        </div>
        <div class="form-container">
            <div class="my-0">
                <x-filament-panels::form id="form" wire:submit="loginWithFortify">
                    {{ $this->form }}

                    <x-filament-panels::form.actions :actions="$this->getCachedFormActions()" :full-width="$this->hasFullWidthFormActions()" />
                </x-filament-panels::form>

                @if (isRegistrationPageEnabled())
                    <div class="or-continue">
                        <span class="left-line"></span>
                        <span>{{ __('messages.or_continue') }}</span>
                        <span class="right-line"></span>
                    </div>

                    <div class="text-center">
                        <span>{{ __('messages.common.dont_have_an_account') }}</span>
                        <a href="{{ route('filament.admin.auth.register') }}">{{ __('messages.common.register') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
