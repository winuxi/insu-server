@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ appLogo() }}" class="logo" style="height:auto!important;width:auto!important;object-fit:cover"
                alt="{{ appName() }}">
        @endcomponent
    @endslot
    <h2>{{ __('messages.mails.hello') . ',' }} </h2>
    <p>{{ __('messages.mails.password_reset_request') }}</p>
    @component('mail::button', ['url' => $url])
        {{ __('auth.reset_password.reset_pwd_btn') }}
    @endcomponent
    <p>{{ __('messages.mails.this_password_reset_link_will_expire_in_count_minutes', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]) }}
    </p>
    <p>{{ __('messages.mails.no_further_action_is_required') }}</p>
    <p>{{ __('messages.mails.regards') }}</p>
    <p>{{ appName() }}</p>
    <hr style="border: 1px solid #f2f0f5">
    <p style="line-height: 1.5em; margin-top: 0; text-align: left; font-size: 14px;">
        {{ __('messages.mails.trouble', [
            'actionText' => Lang::get('messages.mails.reset_password'),
        ]) }}
        <span style="word-break: break-all; display: block; overflow-wrap: break-word;">
            <a href="{{ $url }}">{{ $url }}</a>
        </span>
    </p>
    @slot('footer')
        @component('mail::footer')
            <h6>© {{ date('Y') }} {{ appName() }}.</h6>
        @endcomponent
    @endslot
@endcomponent
