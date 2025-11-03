<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DefaultPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User Management
            'manage_user',
            'create_user',
            'edit_user',
            'delete_user',

            // Contact Management
            'manage_contact',
            'create_contact',
            'edit_contact',
            'delete_contact',

            // Note Management
            'manage_note',
            'create_note',
            'edit_note',
            'delete_note',

            // History Management
            'manage_logged_history',
            'delete_logged_history',

            // Settings Management
            'manage_account_settings',
            'manage_zfa_settings',
            'manage_password_settings',
            'manage_general_settings',
            'manage_company_settings',
            'manage_email_settings',

            // Customer Management
            'manage_customer',
            'create_customer',
            'show_customer',
            'edit_customer',
            'delete_customer',

            // Agent Management
            'manage_agent',
            'create_agent',
            'edit_agent',
            'delete_agent',
            'show_agent',

            // Policy Management
            'manage_policy_type',
            'create_policy_type',
            'edit_policy_type',
            'delete_policy_type',
            'manage_policy_sub_type',
            'create_policy_sub_type',
            'edit_policy_sub_type',
            'delete_policy_sub_type',
            'manage_policy_duration',
            'create_policy_duration',
            'edit_policy_duration',
            'delete_policy_duration',
            'manage_policy_for',
            'create_policy_for',
            'edit_policy_for',
            'delete_policy_for',
            'manage_policy',
            'create_policy',
            'edit_policy',
            'delete_policy',
            'show_policy',

            // Insurance Management
            'manage_insurance',
            'create_insurance',
            'edit_insurance',
            'delete_insurance',
            'show_insurance',

            // Other Permissions
            'create_insured_detail',
            'delete_insured_detail',
            'create_nominee',
            'delete_nominee',

            // Claim Management
            'manage_claim',
            'create_claim',
            'edit_claim',
            'delete_claim',
            'show_claim',
        ];

        // Create permissions if they don't exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

    }
}
