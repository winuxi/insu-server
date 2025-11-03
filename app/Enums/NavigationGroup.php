<?php

namespace App\Enums;

enum NavigationGroup: string
{
    case HOME = 'Home';
    case BUSINESS_MANAGEMENT = 'Business Management';
    case SYSTEM_CONFIGURATION = 'System Configuration';
    case SYSTEM_SETTINGS = 'System Settings';
    case CMS = 'CMS';

    public function label(): string
    {
        return match ($this) {
            self::HOME => __('messages.navigation.home'),
            self::BUSINESS_MANAGEMENT => __('messages.navigation.business_management'),
            self::SYSTEM_CONFIGURATION => __('messages.navigation.system_configuration'),
            self::SYSTEM_SETTINGS => __('messages.navigation.system_settings'),
            self::CMS => 'CMS',
        };
    }
}
