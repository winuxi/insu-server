<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Plan;
use App\Models\SuperAdminSetting;
use App\Models\Testimonial;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        if (! isLandingPageEnabled()) {
            return redirect()->route('auth');
        }

        $sectionData = SuperAdminSetting::whereIn('key', [
            // hero
            'tag_line',
            'hero_section_title',
            'hero_section_short_description',
            // features
            'feature_title_1',
            'feature_description_1',
            'feature_title_2',
            'feature_description_2',
            'feature_title_3',
            'feature_description_3',
            'feature_title_4',
            'feature_description_4',
            'feature_title_5',
            'feature_description_5',
            'feature_title_6',
            'feature_description_6',
            // customer experience
            'customer_experience_title_1',
            'customer_experience_title_2',
            'customer_experience_title_3',
            'customer_experience_title_4',
            'customer_experience_description_1',
            'customer_experience_description_2',
            'customer_experience_description_3',
            'customer_experience_description_4',
            // why choose us
            'why_choose_us_title_1',
            'why_choose_us_title_2',
            'why_choose_us_title_3',
            'why_choose_us_title_4',
            'why_choose_us_description_1',
            'why_choose_us_description_2',
            'why_choose_us_description_3',
            'why_choose_us_description_4',
            // footer
            'twitter_link',
            'facebook_link',
            'linkedin_link',
            'privacy_policy',
            'terms_and_conditions',
        ])->get()->keyBy('key');

        $settingImages = SuperAdminSetting::with('media')->where('key', 'app_name')?->first();

        // Hero Section - Check if required data exists
        $heroSection = null;
        if (
            ! empty($sectionData['hero_section_title']->value ?? '') ||
            ! empty($sectionData['hero_section_short_description']->value ?? '') ||
            ! empty($settingImages?->getFirstMediaUrl(SuperAdminSetting::HERO_SECTION_IMAGE))
        ) {
            $heroSection = new Fluent([
                'tagLine' => $sectionData['tag_line']->value ?? '',
                'title' => $sectionData['hero_section_title']->value ?? '',
                'description' => $sectionData['hero_section_short_description']->value ?? '',
                'image' => $settingImages?->getFirstMediaUrl(SuperAdminSetting::HERO_SECTION_IMAGE) ?? asset('images/hero_section_img.png'),
            ]);
        }


        // Features Section - Only include features that have both title and description
        $featureSection = collect([
            [
                'title' => $sectionData['feature_title_1']->value ?? '',
                'description' => $sectionData['feature_description_1']->value ?? '',
                'image' => $settingImages?->getFirstMediaUrl(SuperAdminSetting::FEATURE_IMAGE_1) ?? asset('images/feature_img_1.png'),
                'textColor' => 'text-indigo-600',
                'iconBg' => 'from-indigo-500 to-purple-600',
                'hoverBg' => 'from-indigo-50 to-purple-50',
            ],
            [
                'title' => $sectionData['feature_title_2']->value ?? '',
                'description' => $sectionData['feature_description_2']->value ?? '',
                'image' => $settingImages?->getFirstMediaUrl(SuperAdminSetting::FEATURE_IMAGE_2) ?? asset('images/feature_img_2.png'),
                'textColor' => 'text-emerald-600',
                'iconBg' => 'from-emerald-500 to-teal-600',
                'hoverBg' => 'from-emerald-50 to-teal-50',
            ],
            [
                'title' => $sectionData['feature_title_3']->value ?? '',
                'description' => $sectionData['feature_description_3']->value ?? '',
                'image' => $settingImages?->getFirstMediaUrl(SuperAdminSetting::FEATURE_IMAGE_3) ?? asset('images/feature_img_3.png'),
                'textColor' => 'text-orange-600',
                'iconBg' => 'from-orange-500 to-red-600',
                'hoverBg' => 'from-orange-50 to-red-50',
            ],
            [
                'title' => $sectionData['feature_title_4']->value ?? '',
                'description' => $sectionData['feature_description_4']->value ?? '',
                'image' => $settingImages?->getFirstMediaUrl(SuperAdminSetting::FEATURE_IMAGE_4) ?? '',
                'textColor' => 'text-blue-600',
                'iconBg' => 'from-blue-500 to-cyan-600',
                'hoverBg' => 'from-blue-50 to-cyan-50',
            ],
            [
                'title' => $sectionData['feature_title_5']->value ?? '',
                'description' => $sectionData['feature_description_5']->value ?? '',
                'image' => $settingImages?->getFirstMediaUrl(SuperAdminSetting::FEATURE_IMAGE_5) ?? '',
                'textColor' => 'text-pink-600',
                'iconBg' => 'from-pink-500 to-fuchsia-600',
                'hoverBg' => 'from-pink-50 to-fuchsia-50',
            ],
            [
                'title' => $sectionData['feature_title_6']->value ?? '',
                'description' => $sectionData['feature_description_6']->value ?? '',
                'image' => $settingImages?->getFirstMediaUrl(SuperAdminSetting::FEATURE_IMAGE_6) ?? '',
                'textColor' => 'text-rose-600',
                'iconBg' => 'from-rose-500 to-rose-600',
                'hoverBg' => 'from-rose-50 to-rose-50',
            ],
        ])->filter(function ($feature) {
            // Only include features that have both title and description
            return ! empty($feature['title']) && ! empty($feature['description']);
        })->map(function ($feature) {
            return new Fluent($feature);
        });

        // Customer Experience Section - Check if has data
        $customerExperienceFeatures = collect([
            [
                'title' => $sectionData['customer_experience_title_1']->value ?? '',
                'description' => 'View active policies, coverage details, and renewal dates',
                'image' => $settingImages?->getFirstMediaUrl(SuperAdminSetting::CUSTOMER_IMAGE_1) ?? asset('images/customer_img_1.png'),
                'iconBg' => 'from-emerald-500 to-teal-600',
            ],
            [
                'title' => $sectionData['customer_experience_title_2']->value ?? '',
                'description' => 'Track payment history and upcoming installments',
                'image' => $settingImages?->getFirstMediaUrl(SuperAdminSetting::CUSTOMER_IMAGE_2) ?? asset('images/customer_img_2.png'),
                'iconBg' => 'from-blue-500 to-cyan-600',
            ],
            [
                'title' => $sectionData['customer_experience_title_3']->value ?? '',
                'description' => 'Download policy documents and contracts instantly',
                'image' => $settingImages?->getFirstMediaUrl(SuperAdminSetting::CUSTOMER_IMAGE_3) ?? '',
                'iconBg' => 'from-orange-500 to-red-600',
            ],
            [
                'title' => $sectionData['customer_experience_title_4']->value ?? '',
                'description' => 'Access terms and policy details anytime, anywhere',
                'image' => $settingImages?->getFirstMediaUrl(SuperAdminSetting::CUSTOMER_IMAGE_4) ?? '',
                'iconBg' => 'from-purple-500 to-pink-600',
            ],
        ])->filter(function ($feature) {
            return ! empty($feature['title']);
        })->map(function ($feature) {
            return new Fluent($feature);
        });

        $customerExperienceSection = null;
        if ($customerExperienceFeatures->isNotEmpty()) {
            $customerExperienceSection = new Fluent([
                'image' => $settingImages?->getFirstMediaUrl(SuperAdminSetting::CUSTOMER_MAIN_IMAGE) ?? asset('images/customer_main_img.jpg'),
                'features' => $customerExperienceFeatures,
            ]);
        }

        // Why Choose Us Section - Only include items with both title and description
        $whyChooseUsSection = collect([
            [
                'title' => $sectionData['why_choose_us_title_1']->value ?? '',
                'description' => $sectionData['why_choose_us_description_1']->value ?? '',
                'image' => $settingImages?->getFirstMediaUrl(SuperAdminSetting::WHY_CHOOSE_US_IMAGE_1) ?? asset('images/why_choose_us_image_1.png'),
                'color' => 'from-blue-500 to-cyan-600',
            ],
            [
                'title' => $sectionData['why_choose_us_title_2']->value ?? '',
                'description' => $sectionData['why_choose_us_description_2']->value ?? '',
                'image' => $settingImages?->getFirstMediaUrl(SuperAdminSetting::WHY_CHOOSE_US_IMAGE_2) ?? asset('images/why_choose_us_image_2.png'),
                'color' => 'from-emerald-500 to-teal-600',
            ],
            [
                'title' => $sectionData['why_choose_us_title_3']->value ?? '',
                'description' => $sectionData['why_choose_us_description_3']->value ?? '',
                'image' => $settingImages?->getFirstMediaUrl(SuperAdminSetting::WHY_CHOOSE_US_IMAGE_3) ?? '',
                'color' => 'from-purple-500 to-pink-600',
            ],
            [
                'title' => $sectionData['why_choose_us_title_4']->value ?? '',
                'description' => $sectionData['why_choose_us_description_4']->value ?? '',
                'image' => $settingImages?->getFirstMediaUrl(SuperAdminSetting::WHY_CHOOSE_US_IMAGE_4) ?? '',
                'color' => 'from-orange-500 to-red-600',
            ],
        ])->filter(function ($item) {
            return ! empty($item['title']) && ! empty($item['description']);
        })->map(function ($item) {
            return new Fluent($item);
        });

        // Testimonials Section
        $testimonialSection = Testimonial::get();
        if ($testimonialSection->isNotEmpty()) {
            $bgGradients = [
                'from-blue-50 to-indigo-50',
                'from-emerald-50 to-teal-50',
                'from-purple-50 to-pink-50',
                'from-orange-50 to-red-50',
            ];

            $avatarGradients = [
                'from-blue-500 to-indigo-600',
                'from-emerald-500 to-teal-600',
                'from-purple-500 to-pink-600',
                'from-orange-500 to-red-600',
            ];

            $borderColors = [
                'border-blue-100',
                'border-emerald-100',
                'border-purple-100',
                'border-orange-100',
            ];

            $testimonialSection = $testimonialSection->map(function ($testimonial, $index) use ($bgGradients, $avatarGradients, $borderColors) {
                $testimonial->bgColor = $bgGradients[$index % count($bgGradients)];
                $testimonial->avatarColor = $avatarGradients[$index % count($avatarGradients)];
                $testimonial->borderColor = $borderColors[$index % count($borderColors)];
                $testimonial->initials = strtoupper(Str::limit(preg_replace('/[^A-Z]/', '', collect(explode(' ', $testimonial->name))->pluck(0)->implode('')), 2, ''));
                $testimonial->image = $testimonial->getFirstMediaUrl(Testimonial::TESTIMONIAL_IMAGE);

                return $testimonial;
            });
        } else {
            $testimonialSection = collect();
        }

        // FAQ Section
        $faqSection = Faq::latest()->limit(3)->get();

        // Footer Section
        $footerSection = new Fluent([
            'twitterLink' => $sectionData['twitter_link']->value ?? '',
            'facebookLink' => $sectionData['facebook_link']->value ?? '',
            'linkedInLink' => $sectionData['linkedin_link']->value ?? '',
        ]);

        $subscriptionPlans = Plan::get();

        $popularPlan = $subscriptionPlans->firstWhere('is_popular', true);

        if ($popularPlan) {
            $subscriptionPlans = $subscriptionPlans->filter(fn ($plan) => $plan->id !== $popularPlan->id)->values();

            $subscriptionPlans->splice(1, 0, [$popularPlan]);
        }

        return view('home.index', compact(
            'heroSection',
            'featureSection',
            'customerExperienceSection',
            'whyChooseUsSection',
            'testimonialSection',
            'faqSection',
            'footerSection',
            'subscriptionPlans'
        ));
    }

    public function privacyPolicy()
    {
        $policy = SuperAdminSetting::where('key', 'privacy_policy')->value('value') ?? '';

        return view('home.privacy-policy', compact('policy'));
    }

    public function termsAndConditions()
    {
        $terms = SuperAdminSetting::where('key', 'terms_and_conditions')->value('value') ?? '';

        return view('home.terms-and-conditions', compact('terms'));
    }

    public function redirectToPayment(Plan $plan)
    {
        session([
            'selected_plan' => [
                'id' => $plan->id,
                'title' => $plan->title,
                'amount' => $plan->amount,
                'interval' => $plan->interval,
                'user_limit' => $plan->user_limit,
                'customer_limit' => $plan->customer_limit,
                'agent_limit' => $plan->agent_limit,
                'is_show_history' => $plan->is_show_history,
            ],
        ]);

        return redirect()->route('filament.admin.pages.payment-gateway');
    }
}
