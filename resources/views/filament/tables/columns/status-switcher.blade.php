<div class="text-sm">
    @if ($getRecord()->payment_method == 'manual' && $getRecord()->payment_status == App\Models\Subscription::IN_REVIEW)
        <x-filament::input.wrapper>
            <x-filament::input.select searchable
                x-on:change="if ($el.value == '1') {
                $wire.call('changePaymentStatus', {{ $getRecord()->id }},{{ $getRecord()->user_id }}, 1)
            } else {
                $wire.call('changePaymentStatus', {{ $getRecord()->id }},{{ $getRecord()->user_id }}, $el.value)
            }">
                <option selected="selected" value="">{{ __('Waiting for approval') }}</option>
                <option value="1">{{ __('Paid') }}</option>
                <option value="5">{{ __('Cancelled') }}</option>
            </x-filament::input.select>
        </x-filament::input.wrapper>
    @elseif ($getRecord()->payment_status == App\Models\Subscription::PAID)
        <x-filament::badge color="success">{{ __('Paid') }}</x-filament::badge>
    @elseif ($getRecord()->payment_status == App\Models\Subscription::CANCELLED)
        <x-filament::badge color="danger">{{ __('Cancelled') }}</x-filament::badge>
    @else
        <div class="fi-ta-text-item-label text-sm leading-6 text-gray-950 dark:text-white  ">
            {{ __('-') }}
        </div>
    @endif
</div>
