<?php

use App\Models\Insurance;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\SuperAdminSetting;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

if (! function_exists('appName')) {
    function appName()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return 'InsuranceSaas';
        }
        if (Schema::hasTable('settings') === false) {
            return '';
        }

        return SuperAdminSetting::where('key', 'app_name')?->value('value') ?? 'InsuranceSaas';
    }
}

if (! function_exists('appNameByAdmin')) {
    function appNameByAdmin()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return 'InsuranceSaas';
        }
        if (Schema::hasTable('settings') === false) {
            return '';
        }

        return Setting::where('key', 'app_name')?->value('value') ?? 'InsuranceSaas';
    }
}

if (! function_exists('appLogo')) {
    function appLogo()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return '';
        }

        if (Schema::hasTable('super_admin_settings') === false) {
            return '';
        }

        return SuperAdminSetting::with('media')->where('key', 'app_name')?->first()?->app_light_logo ?? asset('logo.png');
    }
}

if (! function_exists('darkAppLogo')) {
    function darkAppLogo()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return '';
        }
        if (Schema::hasTable('super_admin_settings') === false) {
            return '';
        }

        return SuperAdminSetting::with('media')->where('key', 'app_name')?->first()?->app_logo ?? asset('logo.png');
    }
}

if (! function_exists('appFavicon')) {
    function appFavicon()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return '';
        }

        if (Schema::hasTable('super_admin_settings') === false) {
            return '';
        }

        return SuperAdminSetting::with('media')->where('key', 'app_name')?->first()?->app_favicon ?? asset('logo.png');
    }
}

if (! function_exists('appLandingLogo')) {
    function appLandingLogo()
    {
        if (Schema::hasTable('super_admin_settings') === false) {
            return '';
        }

        return SuperAdminSetting::with('media')->where('key', 'app_name')?->first()?->app_landing_logo ?? asset('logo.png');
    }
}

if (! function_exists('authBgImage')) {
    function authBgImage()
    {
        if (Schema::hasTable('super_admin_settings') === false) {
            return '';
        }

        $url = SuperAdminSetting::with('media')->where('key', 'app_name')?->first()?->auth_bg_image;

        return ! empty($url) ? SuperAdminSetting::with('media')->where('key', 'app_name')?->first()?->auth_bg_image : asset('images/auth_bg_img.jpg');
    }
}

if (! function_exists('isOwnerEmailVerificationEnabled')) {
    function isOwnerEmailVerificationEnabled()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return '';
        }

        if (Schema::hasTable('super_admin_settings') === false) {
            return '';
        }

        return SuperAdminSetting::where('key', 'owner_email_verification')?->value('value') ?? false;
    }
}

if (! function_exists('isRegistrationPageEnabled')) {
    function isRegistrationPageEnabled()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return '';
        }

        if (Schema::hasTable('super_admin_settings') === false) {
            return '';
        }

        return SuperAdminSetting::where('key', 'registration_page')?->value('value') ?? false;
    }
}

if (! function_exists('isLandingPageEnabled')) {
    function isLandingPageEnabled()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return '';
        }

        if (Schema::hasTable('super_admin_settings') === false) {
            return '';
        }

        return SuperAdminSetting::where('key', 'landing_page')?->value('value') ?? false;
    }
}

if (! function_exists('timezone')) {
    function timezone()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return 'UTC';
        }
        if (Schema::hasTable('settings') === false) {
            return 'UTC';
        }

        return Setting::where('key', 'timezone')?->value('value') ?? 'UTC';
    }
}

if (! function_exists('currencies')) {
    function currencies(): array
    {
        return [
            'USD' => '$',     // US Dollar
            'EUR' => '€',     // Euro
            'GBP' => '£',     // British Pound
            'JPY' => '¥',     // Japanese Yen
            'INR' => '₹',     // Indian Rupee
            'AUD' => 'A$',    // Australian Dollar
            'CAD' => 'C$',    // Canadian Dollar
            'CHF' => 'CHF',   // Swiss Franc
            'CNY' => '¥',     // Chinese Yuan
            'RUB' => '₽',     // Russian Ruble
            'BRL' => 'R$',    // Brazilian Real
            'ZAR' => 'R',     // South African Rand
            'NZD' => 'NZ$',   // New Zealand Dollar
            'SGD' => 'S$',    // Singapore Dollar
            'HKD' => 'HK$',   // Hong Kong Dollar
            'SEK' => 'kr',    // Swedish Krona
            'NOK' => 'kr',    // Norwegian Krone
            'DKK' => 'kr',    // Danish Krone
            'KRW' => '₩',     // South Korean Won
            'MXN' => '$',     // Mexican Peso
            'THB' => '฿',     // Thai Baht
            'MYR' => 'RM',    // Malaysian Ringgit
            'IDR' => 'Rp',    // Indonesian Rupiah
            'PHP' => '₱',     // Philippine Peso
            'PLN' => 'zł',    // Polish Zloty
            'TRY' => '₺',     // Turkish Lira
            'SAR' => '﷼',     // Saudi Riyal
            'AED' => 'د.إ',   // UAE Dirham
            'EGP' => '£',     // Egyptian Pound
            'NGN' => '₦',     // Nigerian Naira
            'PKR' => '₨',     // Pakistani Rupee
            'BDT' => '৳',     // Bangladeshi Taka
            'VND' => '₫',     // Vietnamese Dong
            'KZT' => '₸',     // Kazakhstani Tenge
        ];
    }
}

if (! function_exists('currencySymbol')) {
    function currencySymbol($code = null)
    {
        $currencies = currencies();

        $code = $code
            ? strtoupper($code)
            : strtoupper(Setting::where('key', 'currency_icon')->value('value') ?? 'USD');

        return $currencies[$code] ?? $code;
    }
}

if (! function_exists('currencyCode')) {
    function currencyCode()
    {
        return Setting::where('key', 'currency_icon')->value('value') ?? 'USD';
    }
}

if (! function_exists('invoiceCustomerPrefix')) {
    function invoiceCustomerPrefix($record = null)
    {
        $num = User::latest()?->first()?->id;
        $num = empty($record) ? $num + 1 : $record;

        return Setting::where('key', 'invoice_customer_prefix')->value('value').$num ?? 'INV';
    }
}

if (! function_exists('agentNumberPrefix')) {
    function agentNumberPrefix($record = null)
    {
        $num = User::latest()?->first()?->id;
        $num = empty($record) ? $num + 1 : $record;

        return Setting::where('key', 'agent_number_prefix')->value('value').$num ?? 'AGT';
    }
}

if (! function_exists('insuranceCustomerPrefix')) {
    function insuranceCustomerPrefix($record = null)
    {
        $num = Insurance::latest()?->first()?->id;
        $num = empty($record) ? $num + 1 : $record;

        return Setting::where('key', 'insurance_customer_prefix')->value('value').$num ?? 'INS';
    }
}

if (! function_exists('claimNumberPrefix')) {
    function claimNumberPrefix($record = null, $isClean = false)
    {
        $value = Setting::where('key', 'claim_number_prefix')->value('value');
        if ($isClean) {
            return $value ?? 'claim';
        }
        $num = Insurance::latest()?->first()?->id;
        $num = empty($record) ? $num + 1 : $record;

        return $value.$num ?? 'CLM';
    }
}

if (! function_exists('notify')) {
    function notify($title, $type = 'success')
    {
        return Notification::make()
            ->title($title)
            ->{$type}()
            ->send();
    }
}

if (! function_exists('isStripeEnabled')) {
    function isStripeEnabled()
    {
        return SuperAdminSetting::where('key', 'stripe_enabled')?->value('value') ? true : false;
    }
}

if (! function_exists('isPaypalEnabled')) {
    function isPaypalEnabled()
    {
        return SuperAdminSetting::where('key', 'paypal_enabled')?->value('value') ? true : false;
    }
}

if (! function_exists('isManualEnabled')) {
    function isManualEnabled()
    {
        return SuperAdminSetting::where('key', 'is_manual_enabled')?->value('value') ? true : false;
    }
}

if (! function_exists('stripeCredentials')) {
    function stripeCredentials()
    {
        $stripeEnable = SuperAdminSetting::where('key', 'stripe_enabled')->first()->toArray();
        $key = SuperAdminSetting::where('key', 'stripe_key')->first()->toArray();
        $secret = SuperAdminSetting::where('key', 'stripe_secret')->first()->toArray();

        if (isset($stripeEnable) && $stripeEnable['value'] == 1) {
            if (isset($key) && isset($secret) && ! empty($key['value']) && ! empty($secret['value'])) {
                return [
                    'key' => $key['value'] ?? '',
                    'secret' => $secret['value'] ?? '',
                ];
            }
        }
    }
}

if (! function_exists('paypalCredentials')) {
    function paypalCredentials()
    {
        $paypalEnable = SuperAdminSetting::where('key', 'paypal_enabled')->first()->toArray();
        $client = SuperAdminSetting::where('key', 'paypal_client')->first()->toArray();
        $secret = SuperAdminSetting::where('key', 'paypal_secret')->first()->toArray();
        $model = SuperAdminSetting::where('key', 'paypal_mode')->first()->toArray();

        if (isset($paypalEnable) && $paypalEnable['value'] == 1) {
            if (isset($client) && isset($secret) && ! empty($client['value']) && ! empty($secret['value'])) {
                return [
                    'client' => $client['value'] ?? '',
                    'secret' => $secret['value'] ?? '',
                    'mode' => $model['value'] ?? 'sandbox',
                ];
            }
        }
    }
}

if (! function_exists('googleReCaptchaCredentials')) {
    function googleReCaptchaCredentials()
    {
        $enabledSetting = SuperAdminSetting::where('key', 'google_recaptcha_enabled')->first();
        $keySetting = SuperAdminSetting::where('key', 'google_recaptcha_site_key')->first();
        $secretSetting = SuperAdminSetting::where('key', 'google_recaptcha_secret_key')->first();

        if (
            $enabledSetting && $enabledSetting->value == 1 &&
            $keySetting && $secretSetting &&
            ! empty($keySetting->value) && ! empty($secretSetting->value)
        ) {
            config([
                'captcha.sitekey' => $keySetting->value,
                'captcha.secret' => $secretSetting->value,
            ]);

            return [
                'key' => $keySetting->value,
                'secret' => $secretSetting->value,
            ];
        }

        return null;
    }
}

if (! function_exists('seoTitle')) {
    function seoTitle()
    {
        return SuperAdminSetting::where('key', 'meta_title')?->value('value') ?? appName();
    }
}

if (! function_exists('seoKeywords')) {
    function seoKeywords()
    {
        return SuperAdminSetting::where('key', 'meta_keywords')?->value('value') ?? appName();
    }
}

if (! function_exists('seoDescription')) {
    function seoDescription()
    {
        return SuperAdminSetting::where('key', 'meta_description')?->value('value') ?? '';
    }
}

if (! function_exists('seoImage')) {
    function seoImage()
    {
        return SuperAdminSetting::with('media')->where('key', 'app_name')?->first()?->meta_image ?? '';
    }
}

if (! function_exists('currentActivePlanId')) {
    function currentActivePlanId()
    {
        return Subscription::where('user_id', auth()->user()->id)->where('is_active', Subscription::ACTIVE)->first()?->plan?->id;
    }
}
