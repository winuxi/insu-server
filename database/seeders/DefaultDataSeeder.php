<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Plan;
use App\Models\SuperAdminSetting;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class DefaultDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // owner_email_verification
        SuperAdminSetting::updateOrCreate(
            ['key' => 'owner_email_verification'],
            ['value' => '1']
        );
        // registration_page
        SuperAdminSetting::updateOrCreate(
            ['key' => 'registration_page'],
            ['value' => '1']
        );
        // landing_page
        SuperAdminSetting::updateOrCreate(
            ['key' => 'landing_page'],
            ['value' => 1]
        );
        // hero section
        SuperAdminSetting::updateOrCreate(
            ['key' => 'tag_line'],
            ['value' => 'Empowering Your Insurance Experience']
        );
        SuperAdminSetting::updateOrCreate(
            ['key' => 'hero_section_title'],
            ['value' => 'Welcome to Our Insurance Platform']
        );
        SuperAdminSetting::updateOrCreate(
            ['key' => 'hero_section_short_description'],
            ['value' => 'Manage your insurance policies with ease and efficiency.']
        );
        // feature section
        SuperAdminSetting::updateOrCreate(
            ['key' => 'feature_title_1'],
            ['value' => 'User Registration']
        );
        SuperAdminSetting::updateOrCreate(
            ['key' => 'feature_description_1'],
            ['value' => 'Register your account to access the platform.']
        );
        SuperAdminSetting::updateOrCreate(
            ['key' => 'feature_title_2'],
            ['value' => 'Policy Management']
        );
        SuperAdminSetting::updateOrCreate(
            ['key' => 'feature_description_2'],
            ['value' => 'Manage your policies efficiently.']
        );
        SuperAdminSetting::updateOrCreate(
            ['key' => 'feature_title_3'],
            ['value' => 'Claims Processing']
        );
        SuperAdminSetting::updateOrCreate(
            ['key' => 'feature_description_3'],
            ['value' => 'Process your claims with ease.']
        );
        // customer experience section
        SuperAdminSetting::updateOrCreate(
            ['key' => 'customer_experience_title_1'],
            ['value' => 'Exceptional Customer Experience']
        );
        SuperAdminSetting::updateOrCreate(
            ['key' => 'customer_experience_description_1'],
            ['value' => 'View active policies, coverage details, and renewal dates']
        );
        SuperAdminSetting::updateOrCreate(
            ['key' => 'customer_experience_title_2'],
            ['value' => 'Fast & Reliable Support']
        );
        SuperAdminSetting::updateOrCreate(
            ['key' => 'customer_experience_description_2'],
            ['value' => 'Track payment history and upcoming installments']
        );
        // why choose us section
        SuperAdminSetting::updateOrCreate(
            ['key' => 'why_choose_us_title_1'],
            ['value' => 'Comprehensive Coverage Options']
        );
        SuperAdminSetting::updateOrCreate(
            ['key' => 'why_choose_us_description_1'],
            ['value' => 'We offer a wide range of insurance products to meet your needs.']
        );
        SuperAdminSetting::updateOrCreate(
            ['key' => 'why_choose_us_title_2'],
            ['value' => 'Expert Support Team']
        );
        SuperAdminSetting::updateOrCreate(
            ['key' => 'why_choose_us_description_2'],
            ['value' => 'Our team of experts is here to assist you with any questions or concerns.']
        );
        // footer section
        SuperAdminSetting::updateOrCreate(
            ['key' => 'twitter_link'],
            ['value' => 'https://twitter.com/yourprofile']
        );
        SuperAdminSetting::updateOrCreate(
            ['key' => 'linkedin_link'],
            ['value' => 'https://linkedin.com/in/yourprofile']
        );
        SuperAdminSetting::updateOrCreate(
            ['key' => 'facebook_link'],
            ['value' => 'https://facebook.com/yourprofile']
        );

        // plans
        Plan::create([
            'title' => 'Basic Plan',
            'interval' => Plan::MONTHLY,
            'amount' => 100,
            'user_limit' => 1,
            'customer_limit' => 1,
            'agent_limit' => 1,
            'is_show_history' => 1,
            'is_popular' => 1,
            'short_description' => 'Basic Plan',
        ]);

        // testimonials
        Testimonial::create([
            'name' => 'John Doe',
            'title' => 'Customer',
            'description' => 'This is a great platform for managing my insurance policies.',
        ]);

        Testimonial::create([
            'name' => 'Jane Smith',
            'title' => 'Customer',
            'description' => 'I love the user-friendly interface and the support team is very helpful.',
        ]);

        // faqs
        Faq::create([
            'question' => 'What is the purpose of this platform?',
            'answer' => 'This platform is designed to help you manage your insurance policies efficiently.',
        ]);
    }
}
