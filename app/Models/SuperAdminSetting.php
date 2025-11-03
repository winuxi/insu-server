<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SuperAdminSetting extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'super_admin_settings';

    const LOGO = 'app_logo';

    const FAVICON = 'app_favicon';

    const LIGHT_LOGO = 'app_light_logo';

    const LANDING_LOGO = 'app_landing_logo';

    const AUTH_BG_IMAGE = 'auth_bg_image';

    const META_IMAGE = 'meta_image';

    const HERO_SECTION_IMAGE = 'hero_section_image';

    const FEATURE_IMAGE_1 = 'feature_image_1';

    const FEATURE_IMAGE_2 = 'feature_image_2';

    const FEATURE_IMAGE_3 = 'feature_image_3';

    const FEATURE_IMAGE_4 = 'feature_image_4';

    const FEATURE_IMAGE_5 = 'feature_image_5';

    const FEATURE_IMAGE_6 = 'feature_image_6';

    const CUSTOMER_MAIN_IMAGE = 'customer_main_image';

    const CUSTOMER_IMAGE_1 = 'customer_image_1';

    const CUSTOMER_IMAGE_2 = 'customer_image_2';

    const CUSTOMER_IMAGE_3 = 'customer_image_3';

    const CUSTOMER_IMAGE_4 = 'customer_image_4';

    const WHY_CHOOSE_US_IMAGE_1 = 'why_choose_us_image_1';

    const WHY_CHOOSE_US_IMAGE_2 = 'why_choose_us_image_2';

    const WHY_CHOOSE_US_IMAGE_3 = 'why_choose_us_image_3';

    const WHY_CHOOSE_US_IMAGE_4 = 'why_choose_us_image_4';

    protected $fillable = [
        'key',
        'value',
    ];

    public function getAppLogoAttribute()
    {
        return $this->getFirstMediaUrl(self::LOGO) ?? asset('images/avatar.png');
    }

    public function getAppFaviconAttribute()
    {
        return $this->getFirstMediaUrl(self::FAVICON) ?? asset('images/avatar.png');
    }

    public function getAppLightLogoAttribute()
    {
        return $this->getFirstMediaUrl(self::LIGHT_LOGO) ?? asset('images/avatar.png');
    }

    public function getAppLandingLogoAttribute()
    {
        return $this->getFirstMediaUrl(self::LANDING_LOGO) ?? asset('images/avatar.png');
    }

    public function getAuthBgImageAttribute()
    {
        return $this->getFirstMediaUrl(self::AUTH_BG_IMAGE) ?? '';
    }

    public function getMetaImageAttribute()
    {
        return $this->getFirstMediaUrl(self::META_IMAGE) ?? '';
    }
}
