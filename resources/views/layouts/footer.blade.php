<!-- Footer -->
<footer class="bg-gray-900 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <div class="flex items-center mb-4 sm:mb-0">
                <div class="w-20 h-20 bg-gradient-to-br rounded-xl flex items-center justify-center mr-3">
                    <img src="{{ appLandingLogo() }}" alt="">
                </div>
            </div>

            <div class="flex space-x-3">
                <a href="{{ $footerSection->twitterLink ?? '#' }}"
                    class="w-8 h-8 bg-gray-800 hover:bg-indigo-600 rounded-lg flex items-center justify-center transition-all duration-300">
                    <i class="fab fa-twitter text-gray-300 hover:text-white text-sm"></i>
                </a>
                <a href="{{ $footerSection->linkedInLink ?? '#' }}"
                    class="w-8 h-8 bg-gray-800 hover:bg-indigo-600 rounded-lg flex items-center justify-center transition-all duration-300">
                    <i class="fab fa-linkedin text-gray-300 hover:text-white text-sm"></i>
                </a>
                <a href="{{ $footerSection->facebookLink ?? '#' }}"
                    class="w-8 h-8 bg-gray-800 hover:bg-indigo-600 rounded-lg flex items-center justify-center transition-all duration-300">
                    <i class="fab fa-facebook text-gray-300 hover:text-white text-sm"></i>
                </a>
            </div>
        </div>

        <div class="text-center mt-6 pt-6 border-t border-gray-800">
            <p class="text-gray-400 text-sm mb-3">
                &copy; {{ date('Y') }} {{ appName() }}. {{ __('messages.landing.footer.rights') }}
            </p>
            <div class="flex justify-center space-x-6 text-xs">
                <a href="{{ route('privacy.policy') }}"
                    class="text-gray-400 hover:text-indigo-400 transition-colors">
                    {{ __('messages.landing.footer.privacy_policy') }}
                </a>
                <a href="{{ route('terms.conditions') }}"
                    class="text-gray-400 hover:text-indigo-400 transition-colors">
                    {{ __('messages.landing.footer.terms_conditions') }}
                </a>
            </div>
        </div>
    </div>
</footer>
