<?php

namespace App\Filament\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static string $routePath = '/dashboard';

    public static function getNavigationGroup(): ?string
    {
        return \App\Enums\NavigationGroup::HOME->label();
    }
}
