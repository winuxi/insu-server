<?php

namespace App\MediaLibrary;

use App\Models\ClaimDocument;
use App\Models\InsuranceDocument;
use App\Models\SuperAdminSetting;
use App\Models\Testimonial;
use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

/**
 * Class CustomPathGenerator
 */
class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        $path = '{PARENT_DIR}'.DIRECTORY_SEPARATOR.$media->id.DIRECTORY_SEPARATOR;

        switch ($media->collection_name) {
            case User::PROFILE:
                return str_replace('{PARENT_DIR}', User::PROFILE, $path);
            case ClaimDocument::FILE:
                return str_replace('{PARENT_DIR}', ClaimDocument::FILE, $path);
            case InsuranceDocument::FILE:
                return str_replace('{PARENT_DIR}', InsuranceDocument::FILE, $path);
            case SuperAdminSetting::LOGO:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::LOGO, $path);
            case SuperAdminSetting::FAVICON:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::FAVICON, $path);
            case SuperAdminSetting::LIGHT_LOGO:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::LIGHT_LOGO, $path);
            case SuperAdminSetting::LANDING_LOGO:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::LANDING_LOGO, $path);
            case SuperAdminSetting::META_IMAGE:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::META_IMAGE, $path);
            case SuperAdminSetting::HERO_SECTION_IMAGE:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::HERO_SECTION_IMAGE, $path);
            case SuperAdminSetting::FEATURE_IMAGE_1:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::FEATURE_IMAGE_1, $path);
            case SuperAdminSetting::FEATURE_IMAGE_2:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::FEATURE_IMAGE_2, $path);
            case SuperAdminSetting::FEATURE_IMAGE_3:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::FEATURE_IMAGE_3, $path);
            case SuperAdminSetting::FEATURE_IMAGE_4:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::FEATURE_IMAGE_4, $path);
            case SuperAdminSetting::FEATURE_IMAGE_5:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::FEATURE_IMAGE_5, $path);
            case SuperAdminSetting::FEATURE_IMAGE_6:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::FEATURE_IMAGE_6, $path);
            case SuperAdminSetting::CUSTOMER_IMAGE_1:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::CUSTOMER_IMAGE_1, $path);
            case SuperAdminSetting::CUSTOMER_IMAGE_2:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::CUSTOMER_IMAGE_2, $path);
            case SuperAdminSetting::CUSTOMER_IMAGE_3:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::CUSTOMER_IMAGE_3, $path);
            case SuperAdminSetting::CUSTOMER_IMAGE_4:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::CUSTOMER_IMAGE_4, $path);
            case SuperAdminSetting::CUSTOMER_MAIN_IMAGE:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::CUSTOMER_MAIN_IMAGE, $path);
            case SuperAdminSetting::WHY_CHOOSE_US_IMAGE_1:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::WHY_CHOOSE_US_IMAGE_1, $path);
            case SuperAdminSetting::WHY_CHOOSE_US_IMAGE_2:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::WHY_CHOOSE_US_IMAGE_2, $path);
            case SuperAdminSetting::WHY_CHOOSE_US_IMAGE_3:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::WHY_CHOOSE_US_IMAGE_3, $path);
            case SuperAdminSetting::WHY_CHOOSE_US_IMAGE_4:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::WHY_CHOOSE_US_IMAGE_4, $path);
            case Testimonial::TESTIMONIAL_IMAGE:
                return str_replace('{PARENT_DIR}', Testimonial::TESTIMONIAL_IMAGE, $path);
            case SuperAdminSetting::AUTH_BG_IMAGE:
                return str_replace('{PARENT_DIR}', SuperAdminSetting::AUTH_BG_IMAGE, $path);
            case 'default':
                return '';
        }
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media).'thumbnails/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media).'rs-images/';
    }
}
