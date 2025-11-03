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
                <h2 class="mt-5 text-lg font-semibold text-center">
                    {{ __('Authenticate with your code') }}
                </h2>

                @if ($errors->any())
                    <div class="mt-4 bg-red-50 text-red-700 p-4 rounded-lg">
                        <p class="font-medium">{{ __('Invalid authentication code.') }}</p>
                    </div>
                @endif

                @if ($twoFactorType === 'email' || $twoFactorType === 'phone')
                    <div wire:poll.5s>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $this->resend }}
                        </p>
                    </div>
                @endif

                <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-8 mt-10">
                    @csrf

                    <div style="display: none">
                        <input type="text" id="recovery_code" name="recovery_code" value=""
                            class="focus:ring-2 focus:ring-[#6219a6] focus:border-[#6219a6] focus:ring-opacity-50">
                    </div>

                    {{ $this->form }}

                    <div class="flex items-center justify-between mt-6">
                        <x-filament::button type="submit"
                            class="w-full hover:bg-[#4d1685] focus:ring-2 focus:ring-[#6219a6]"
                            style="background-color: #6219a6; border-color: #6219a6;">
                            Login
                        </x-filament::button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('resent', () => {
            // Immediately disable the button
            Livewire.dispatch('$refresh');
        });
    });
</script>
