-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 02, 2025 at 05:29 AM
-- Server version: 8.3.0
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `insurance`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint UNSIGNED NOT NULL,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint UNSIGNED DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`, `tenant_id`) VALUES
(1, 'Resource', 'User Created', 'App\\Models\\User', 'Created', 1, NULL, NULL, '{\"id\": 1, \"name\": \"Super Admin\", \"email\": \"superadmin@gmail.com\", \"tenant_id\": null, \"created_at\": \"2025-07-02 05:28:56\", \"updated_at\": \"2025-07-02 05:28:56\", \"email_verified_at\": \"2025-07-02 05:28:56\"}', NULL, '2025-07-01 23:58:56', '2025-07-01 23:58:56', NULL),
(2, 'Resource', 'User Created', 'App\\Models\\User', 'Created', 1, NULL, NULL, '{\"id\": 1, \"name\": \"Super Admin\", \"email\": \"superadmin@gmail.com\", \"tenant_id\": null, \"created_at\": \"2025-07-02 05:28:56\", \"updated_at\": \"2025-07-02 05:28:56\", \"email_verified_at\": \"2025-07-02 05:28:56\"}', NULL, '2025-07-01 23:58:56', '2025-07-01 23:58:56', NULL),
(3, 'Resource', 'User Created', 'App\\Models\\User', 'Created', 1, NULL, NULL, '{\"id\": 1, \"name\": \"Super Admin\", \"email\": \"superadmin@gmail.com\", \"tenant_id\": null, \"created_at\": \"2025-07-02 05:28:56\", \"updated_at\": \"2025-07-02 05:28:56\", \"email_verified_at\": \"2025-07-02 05:28:56\"}', NULL, '2025-07-01 23:58:56', '2025-07-01 23:58:56', NULL),
(4, 'Resource', 'User Created', 'App\\Models\\User', 'Created', 2, NULL, NULL, '{\"id\": 2, \"name\": \"Admin\", \"email\": \"admin@gmail.com\", \"tenant_id\": \"4a87dfb1-eb6d-48de-a2a9-adb70e01a38a\", \"created_at\": \"2025-07-02 05:28:56\", \"updated_at\": \"2025-07-02 05:28:56\", \"email_verified_at\": \"2025-07-02 05:28:56\"}', NULL, '2025-07-01 23:58:56', '2025-07-01 23:58:56', NULL),
(5, 'Resource', 'User Created', 'App\\Models\\User', 'Created', 2, NULL, NULL, '{\"id\": 2, \"name\": \"Admin\", \"email\": \"admin@gmail.com\", \"tenant_id\": \"4a87dfb1-eb6d-48de-a2a9-adb70e01a38a\", \"created_at\": \"2025-07-02 05:28:56\", \"updated_at\": \"2025-07-02 05:28:56\", \"email_verified_at\": \"2025-07-02 05:28:56\"}', NULL, '2025-07-01 23:58:56', '2025-07-01 23:58:56', NULL),
(6, 'Resource', 'User Created', 'App\\Models\\User', 'Created', 2, NULL, NULL, '{\"id\": 2, \"name\": \"Admin\", \"email\": \"admin@gmail.com\", \"tenant_id\": \"4a87dfb1-eb6d-48de-a2a9-adb70e01a38a\", \"created_at\": \"2025-07-02 05:28:56\", \"updated_at\": \"2025-07-02 05:28:56\", \"email_verified_at\": \"2025-07-02 05:28:56\"}', NULL, '2025-07-01 23:58:56', '2025-07-01 23:58:56', NULL),
(7, 'Resource', 'Plan Created', 'App\\Models\\Plan', 'Created', 1, NULL, NULL, '{\"id\": 1, \"title\": \"Basic Plan\", \"amount\": 100, \"interval\": 1, \"created_at\": \"2025-07-02 05:28:56\", \"is_popular\": 1, \"updated_at\": \"2025-07-02 05:28:56\", \"user_limit\": 1, \"agent_limit\": 1, \"customer_limit\": 1, \"is_show_history\": 1, \"short_description\": \"Basic Plan\"}', NULL, '2025-07-01 23:58:56', '2025-07-01 23:58:56', NULL),
(8, 'Resource', 'Testimonial Created', 'App\\Models\\Testimonial', 'Created', 1, NULL, NULL, '{\"id\": 1, \"name\": \"John Doe\", \"title\": \"Customer\", \"created_at\": \"2025-07-02 05:28:56\", \"updated_at\": \"2025-07-02 05:28:56\", \"description\": \"This is a great platform for managing my insurance policies.\"}', NULL, '2025-07-01 23:58:56', '2025-07-01 23:58:56', NULL),
(9, 'Resource', 'Testimonial Created', 'App\\Models\\Testimonial', 'Created', 2, NULL, NULL, '{\"id\": 2, \"name\": \"Jane Smith\", \"title\": \"Customer\", \"created_at\": \"2025-07-02 05:28:56\", \"updated_at\": \"2025-07-02 05:28:56\", \"description\": \"I love the user-friendly interface and the support team is very helpful.\"}', NULL, '2025-07-01 23:58:56', '2025-07-01 23:58:56', NULL),
(10, 'Resource', 'Faq Created', 'App\\Models\\Faq', 'Created', 1, NULL, NULL, '{\"id\": 1, \"answer\": \"This platform is designed to help you manage your insurance policies efficiently.\", \"question\": \"What is the purpose of this platform?\", \"created_at\": \"2025-07-02 05:28:56\", \"updated_at\": \"2025-07-02 05:28:56\"}', NULL, '2025-07-01 23:58:56', '2025-07-01 23:58:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `claims`
--

CREATE TABLE `claims` (
  `id` bigint UNSIGNED NOT NULL,
  `claim_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `claim_date` date NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `insurance_id` bigint UNSIGNED NOT NULL,
  `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `claim_documents`
--

CREATE TABLE `claim_documents` (
  `id` bigint UNSIGNED NOT NULL,
  `claim_id` bigint UNSIGNED NOT NULL,
  `document_type_id` bigint UNSIGNED NOT NULL,
  `status` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_types`
--

CREATE TABLE `document_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `domains`
--

CREATE TABLE `domains` (
  `id` int UNSIGNED NOT NULL,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `durations`
--

CREATE TABLE `durations` (
  `id` bigint UNSIGNED NOT NULL,
  `duration_terms` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration_in_months` decimal(8,2) NOT NULL,
  `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `created_at`, `updated_at`) VALUES
(1, 'What is the purpose of this platform?', 'This platform is designed to help you manage your insurance policies efficiently.', '2025-07-01 23:58:56', '2025-07-01 23:58:56');

-- --------------------------------------------------------

--
-- Table structure for table `insurances`
--

CREATE TABLE `insurances` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `agent_id` bigint UNSIGNED NOT NULL,
  `policy_id` bigint UNSIGNED NOT NULL,
  `policy_pricing_id` bigint UNSIGNED NOT NULL,
  `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agent_commission` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `status` int NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `insurance_documents`
--

CREATE TABLE `insurance_documents` (
  `id` bigint UNSIGNED NOT NULL,
  `insurance_id` bigint UNSIGNED NOT NULL,
  `document_type_id` bigint UNSIGNED NOT NULL,
  `status` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `insurance_installments`
--

CREATE TABLE `insurance_installments` (
  `id` bigint UNSIGNED NOT NULL,
  `insurance_id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `policy_id` bigint UNSIGNED NOT NULL,
  `order_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `insurance_insureds`
--

CREATE TABLE `insurance_insureds` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `insurance_id` bigint UNSIGNED NOT NULL,
  `dob` date DEFAULT NULL,
  `age` decimal(5,2) DEFAULT NULL,
  `gender` tinyint DEFAULT NULL,
  `blood_group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `height` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `insurance_nominees`
--

CREATE TABLE `insurance_nominees` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `insurance_id` bigint UNSIGNED NOT NULL,
  `dob` date DEFAULT NULL,
  `percentage` decimal(8,2) DEFAULT NULL,
  `relation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `insurance_payments`
--

CREATE TABLE `insurance_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `insurance_id` bigint UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `installment_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint UNSIGNED NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2019_09_15_000010_create_tenants_table', 1),
(5, '2019_09_15_000020_create_domains_table', 1),
(6, '2025_05_23_105417_create_policy_types_table', 1),
(7, '2025_05_23_105556_create_policy_sub_types_table', 1),
(8, '2025_05_23_111342_create_durations_table', 1),
(9, '2025_05_23_112946_create_document_types_table', 1),
(10, '2025_05_23_114939_create_taxes_table', 1),
(11, '2025_05_23_122135_modify_users_table', 1),
(12, '2025_05_23_123740_create_user_addresses_table', 1),
(13, '2025_05_23_124049_create_user_company_details_table', 1),
(14, '2025_05_26_040639_create_media_table', 1),
(15, '2025_05_26_053134_create_permission_tables', 1),
(16, '2025_05_26_070320_create_policies_table', 1),
(17, '2025_05_26_095507_create_policy_pricings_table', 1),
(18, '2025_05_26_111516_create_insurances_table', 1),
(19, '2025_05_26_224201_create_insureds_table', 1),
(20, '2025_05_26_233652_create_nominees_table', 1),
(21, '2025_05_26_235110_create_documents_table', 1),
(22, '2025_05_27_002532_create_payments_table', 1),
(23, '2025_05_27_012517_create_claims_table', 1),
(24, '2025_05_27_044355_create_contacts_table', 1),
(25, '2025_05_27_050331_create_settings_table', 1),
(26, '2025_05_28_023817_create_claim_documents_table', 1),
(27, '2025_05_29_015337_add_created_by_to_users_table', 1),
(28, '2025_05_30_222135_create_insurance_installments_table', 1),
(29, '2025_06_01_214453_modify_insurance_payments_table', 1),
(30, '2025_06_02_030731_add_two_factor_columns_to_users_table', 1),
(31, '2025_06_02_105114_create_activity_log_table', 1),
(32, '2025_06_02_105115_add_event_column_to_activity_log_table', 1),
(33, '2025_06_02_105116_add_batch_uuid_column_to_activity_log_table', 1),
(34, '2025_06_02_110755_add_two_factor_type_column_to_users_table', 1),
(35, '2025_06_02_202213_create_plans_table', 1),
(36, '2025_06_02_205741_create_super_admin_settings_table', 1),
(37, '2025_06_03_044041_add_tenant_id_column_to_users_table', 1),
(38, '2025_06_04_083616_add_user_id_in_policies_table', 1),
(39, '2025_06_05_042700_create_subscriptions_table', 1),
(40, '2025_06_09_043327_add_tenant_id_column_to_durations_table', 1),
(41, '2025_06_09_062125_add_tenant_id_column_to_policies_table', 1),
(42, '2025_06_09_062502_add_tenant_id_column_to_insurances_table', 1),
(43, '2025_06_09_062644_add_tenant_id_column_to_contacts_table', 1),
(44, '2025_06_09_062749_add_tenant_id_column_to_claims_table', 1),
(45, '2025_06_09_062916_add_tenant_id_column_to_policy_types_table', 1),
(46, '2025_06_09_063118_add_tenant_id_column_to_policy_sub_types_table', 1),
(47, '2025_06_09_063321_add_tenant_id_column_to_document_types_table', 1),
(48, '2025_06_09_090126_add_tenant_id_to_roles_table', 1),
(49, '2025_06_09_100528_add_tenant_id_to_settings_table', 1),
(50, '2025_06_09_122547_add_tenant_id_to_role_has_permissions_table', 1),
(51, '2025_06_10_041009_add_tenant_id_to_taxes_table', 1),
(52, '2025_06_17_193649_create_testimonials_table', 1),
(53, '2025_06_17_205401_create_faqs_table', 1),
(54, '2025_06_18_003433_modify_super_admin_settings_table', 1),
(55, '2025_06_18_163858_add_is_popular_to_plans_table', 1),
(56, '2025_06_19_002241_add_tenant_id_to_activity_log_table', 1),
(57, '2025_06_19_165700_update_foreign_keys_on_insurance_table', 1),
(58, '2025_06_26_102440_add_themes_settings_to_users_table', 1),
(59, '2025_06_26_152725_add_short_description_to_plans_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'manage_user', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(2, 'create_user', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(3, 'edit_user', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(4, 'delete_user', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(5, 'manage_contact', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(6, 'create_contact', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(7, 'edit_contact', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(8, 'delete_contact', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(9, 'manage_note', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(10, 'create_note', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(11, 'edit_note', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(12, 'delete_note', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(13, 'manage_logged_history', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(14, 'delete_logged_history', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(15, 'manage_account_settings', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(16, 'manage_zfa_settings', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(17, 'manage_password_settings', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(18, 'manage_general_settings', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(19, 'manage_company_settings', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(20, 'manage_email_settings', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(21, 'manage_customer', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(22, 'create_customer', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(23, 'show_customer', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(24, 'edit_customer', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(25, 'delete_customer', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(26, 'manage_agent', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(27, 'create_agent', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(28, 'edit_agent', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(29, 'delete_agent', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(30, 'show_agent', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(31, 'manage_policy_type', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(32, 'create_policy_type', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(33, 'edit_policy_type', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(34, 'delete_policy_type', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(35, 'manage_policy_sub_type', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(36, 'create_policy_sub_type', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(37, 'edit_policy_sub_type', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(38, 'delete_policy_sub_type', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(39, 'manage_policy_duration', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(40, 'create_policy_duration', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(41, 'edit_policy_duration', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(42, 'delete_policy_duration', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(43, 'manage_policy_for', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(44, 'create_policy_for', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(45, 'edit_policy_for', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(46, 'delete_policy_for', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(47, 'manage_policy', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(48, 'create_policy', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(49, 'edit_policy', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(50, 'delete_policy', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(51, 'show_policy', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(52, 'manage_insurance', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(53, 'create_insurance', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(54, 'edit_insurance', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(55, 'delete_insurance', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(56, 'show_insurance', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(57, 'create_insured_detail', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(58, 'delete_insured_detail', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(59, 'create_nominee', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(60, 'delete_nominee', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(61, 'manage_claim', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(62, 'create_claim', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(63, 'edit_claim', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(64, 'delete_claim', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(65, 'show_claim', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `interval` tinyint NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `user_limit` int DEFAULT NULL,
  `customer_limit` int DEFAULT NULL,
  `agent_limit` int DEFAULT NULL,
  `is_show_history` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_popular` tinyint(1) NOT NULL DEFAULT '0',
  `short_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `title`, `interval`, `amount`, `user_limit`, `customer_limit`, `agent_limit`, `is_show_history`, `created_at`, `updated_at`, `is_popular`, `short_description`) VALUES
(1, 'Basic Plan', 1, 100.00, 1, 1, 1, 1, '2025-07-01 23:58:56', '2025-07-01 23:58:56', 1, 'Basic Plan');

-- --------------------------------------------------------

--
-- Table structure for table `policies`
--

CREATE TABLE `policies` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `policy_type_id` bigint UNSIGNED NOT NULL,
  `policy_sub_type_id` bigint UNSIGNED NOT NULL,
  `coverage_type` int NOT NULL,
  `total_insured_person` int NOT NULL,
  `liability_risk` int NOT NULL,
  `sum_assured` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `policy_document_type_id` bigint UNSIGNED DEFAULT NULL,
  `claim_document_type_id` bigint UNSIGNED DEFAULT NULL,
  `tax_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `term` text COLLATE utf8mb4_unicode_ci,
  `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `policy_pricings`
--

CREATE TABLE `policy_pricings` (
  `id` bigint UNSIGNED NOT NULL,
  `policy_id` bigint UNSIGNED NOT NULL,
  `duration_id` bigint UNSIGNED NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `policy_sub_types`
--

CREATE TABLE `policy_sub_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `policy_type_id` bigint UNSIGNED NOT NULL,
  `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `policy_types`
--

CREATE TABLE `policy_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `tenant_id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, NULL, 'super-admin', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(2, '4a87dfb1-eb6d-48de-a2a9-adb70e01a38a', 'admin', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(3, '4a87dfb1-eb6d-48de-a2a9-adb70e01a38a', 'customer', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(4, '4a87dfb1-eb6d-48de-a2a9-adb70e01a38a', 'agent', 'web', '2025-07-01 23:58:56', '2025-07-01 23:58:56');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The unique key for the setting',
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'The value of the setting',
  `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `plan_id` bigint UNSIGNED NOT NULL,
  `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` tinyint DEFAULT NULL,
  `is_active` tinyint DEFAULT NULL,
  `meta` longtext COLLATE utf8mb4_unicode_ci,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `super_admin_settings`
--

CREATE TABLE `super_admin_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The unique key for the setting',
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `super_admin_settings`
--

INSERT INTO `super_admin_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'owner_email_verification', '1', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(2, 'registration_page', '1', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(3, 'landing_page', '1', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(4, 'tag_line', 'Empowering Your Insurance Experience', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(5, 'hero_section_title', 'Welcome to Our Insurance Platform', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(6, 'hero_section_short_description', 'Manage your insurance policies with ease and efficiency.', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(7, 'feature_title_1', 'User Registration', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(8, 'feature_description_1', 'Register your account to access the platform.', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(9, 'feature_title_2', 'Policy Management', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(10, 'feature_description_2', 'Manage your policies efficiently.', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(11, 'feature_title_3', 'Claims Processing', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(12, 'feature_description_3', 'Process your claims with ease.', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(13, 'customer_experience_title_1', 'Exceptional Customer Experience', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(14, 'customer_experience_description_1', 'View active policies, coverage details, and renewal dates', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(15, 'customer_experience_title_2', 'Fast & Reliable Support', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(16, 'customer_experience_description_2', 'Track payment history and upcoming installments', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(17, 'why_choose_us_title_1', 'Comprehensive Coverage Options', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(18, 'why_choose_us_description_1', 'We offer a wide range of insurance products to meet your needs.', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(19, 'why_choose_us_title_2', 'Expert Support Team', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(20, 'why_choose_us_description_2', 'Our team of experts is here to assist you with any questions or concerns.', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(21, 'twitter_link', 'https://twitter.com/yourprofile', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(22, 'linkedin_link', 'https://linkedin.com/in/yourprofile', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(23, 'facebook_link', 'https://facebook.com/yourprofile', '2025-07-01 23:58:56', '2025-07-01 23:58:56');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint UNSIGNED NOT NULL,
  `tax` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_rate` decimal(5,2) NOT NULL,
  `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenant_username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `data` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `tenant_username`, `created_at`, `updated_at`, `data`) VALUES
('4a87dfb1-eb6d-48de-a2a9-adb70e01a38a', 'admin', '2025-07-01 23:58:56', '2025-07-01 23:58:56', '[]');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'Customer', 'This is a great platform for managing my insurance policies.', '2025-07-01 23:58:56', '2025-07-01 23:58:56'),
(2, 'Jane Smith', 'Customer', 'I love the user-friendly interface and the support team is very helpful.', '2025-07-01 23:58:56', '2025-07-01 23:58:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_type` enum('authenticator','email','phone') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` tinyint DEFAULT NULL,
  `created_by_id` bigint UNSIGNED DEFAULT NULL,
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'default',
  `theme_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `tenant_id`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_type`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`, `phone`, `gender`, `created_by_id`, `theme`, `theme_color`) VALUES
(1, 'Super Admin', 'superadmin@gmail.com', '2025-07-01 23:58:56', '$2y$12$OmvnNyr5ZLjp5ohCSukIw.0ma0D0aqkcaPc9o6Z3FT7Zi1QSYcBGm', NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-01 23:58:56', '2025-07-01 23:58:56', NULL, NULL, NULL, 'default', NULL),
(2, 'Admin', 'admin@gmail.com', '2025-07-01 23:58:56', '$2y$12$urXZtxWy058n431oh1CJVOzqNMMyGVZLEJNPpDv249yLG4Mtj8EZ.', '4a87dfb1-eb6d-48de-a2a9-adb70e01a38a', NULL, NULL, NULL, NULL, NULL, '2025-07-01 23:58:56', '2025-07-01 23:58:56', NULL, NULL, NULL, 'default', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_company_details`
--

CREATE TABLE `user_company_details` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marital_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `height` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `claims`
--
ALTER TABLE `claims`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `claims_claim_number_unique` (`claim_number`),
  ADD KEY `claims_customer_id_foreign` (`customer_id`),
  ADD KEY `claims_insurance_id_foreign` (`insurance_id`),
  ADD KEY `claims_tenant_id_foreign` (`tenant_id`);

--
-- Indexes for table `claim_documents`
--
ALTER TABLE `claim_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `claim_documents_claim_id_foreign` (`claim_id`),
  ADD KEY `claim_documents_document_type_id_foreign` (`document_type_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_tenant_id_foreign` (`tenant_id`);

--
-- Indexes for table `document_types`
--
ALTER TABLE `document_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_types_tenant_id_foreign` (`tenant_id`);

--
-- Indexes for table `domains`
--
ALTER TABLE `domains`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `domains_domain_unique` (`domain`),
  ADD KEY `domains_tenant_id_foreign` (`tenant_id`);

--
-- Indexes for table `durations`
--
ALTER TABLE `durations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `durations_tenant_id_foreign` (`tenant_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insurances`
--
ALTER TABLE `insurances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `insurances_customer_id_foreign` (`customer_id`),
  ADD KEY `insurances_agent_id_foreign` (`agent_id`),
  ADD KEY `insurances_policy_id_foreign` (`policy_id`),
  ADD KEY `insurances_tenant_id_foreign` (`tenant_id`),
  ADD KEY `insurances_policy_pricing_id_foreign` (`policy_pricing_id`);

--
-- Indexes for table `insurance_documents`
--
ALTER TABLE `insurance_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `insurance_documents_insurance_id_foreign` (`insurance_id`),
  ADD KEY `insurance_documents_document_type_id_foreign` (`document_type_id`);

--
-- Indexes for table `insurance_installments`
--
ALTER TABLE `insurance_installments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `insurance_installments_insurance_id_foreign` (`insurance_id`),
  ADD KEY `insurance_installments_customer_id_foreign` (`customer_id`),
  ADD KEY `insurance_installments_policy_id_foreign` (`policy_id`);

--
-- Indexes for table `insurance_insureds`
--
ALTER TABLE `insurance_insureds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `insurance_insureds_insurance_id_foreign` (`insurance_id`);

--
-- Indexes for table `insurance_nominees`
--
ALTER TABLE `insurance_nominees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `insurance_nominees_insurance_id_foreign` (`insurance_id`);

--
-- Indexes for table `insurance_payments`
--
ALTER TABLE `insurance_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `insurance_payments_insurance_id_foreign` (`insurance_id`),
  ADD KEY `insurance_payments_installment_id_foreign` (`installment_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `media_order_column_index` (`order_column`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `policies`
--
ALTER TABLE `policies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `policies_policy_type_id_foreign` (`policy_type_id`),
  ADD KEY `policies_policy_sub_type_id_foreign` (`policy_sub_type_id`),
  ADD KEY `policies_policy_document_type_id_foreign` (`policy_document_type_id`),
  ADD KEY `policies_claim_document_type_id_foreign` (`claim_document_type_id`),
  ADD KEY `policies_tax_id_foreign` (`tax_id`),
  ADD KEY `policies_user_id_foreign` (`user_id`),
  ADD KEY `policies_tenant_id_foreign` (`tenant_id`);

--
-- Indexes for table `policy_pricings`
--
ALTER TABLE `policy_pricings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `policy_pricings_policy_id_foreign` (`policy_id`),
  ADD KEY `policy_pricings_duration_id_foreign` (`duration_id`);

--
-- Indexes for table `policy_sub_types`
--
ALTER TABLE `policy_sub_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `policy_sub_types_policy_type_id_foreign` (`policy_type_id`),
  ADD KEY `policy_sub_types_tenant_id_foreign` (`tenant_id`);

--
-- Indexes for table `policy_types`
--
ALTER TABLE `policy_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `policy_types_tenant_id_foreign` (`tenant_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`),
  ADD KEY `role_has_permissions_tenant_id_foreign` (`tenant_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_tenant_id_foreign` (`tenant_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_user_id_foreign` (`user_id`),
  ADD KEY `subscriptions_plan_id_foreign` (`plan_id`);

--
-- Indexes for table `super_admin_settings`
--
ALTER TABLE `super_admin_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `super_admin_settings_key_unique` (`key`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taxes_tenant_id_foreign` (`tenant_id`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_created_by_id_foreign` (`created_by_id`),
  ADD KEY `users_tenant_id_foreign` (`tenant_id`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_company_details`
--
ALTER TABLE `user_company_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_company_details_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `claims`
--
ALTER TABLE `claims`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `claim_documents`
--
ALTER TABLE `claim_documents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_types`
--
ALTER TABLE `document_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `domains`
--
ALTER TABLE `domains`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `durations`
--
ALTER TABLE `durations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `insurances`
--
ALTER TABLE `insurances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insurance_documents`
--
ALTER TABLE `insurance_documents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insurance_installments`
--
ALTER TABLE `insurance_installments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insurance_insureds`
--
ALTER TABLE `insurance_insureds`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insurance_nominees`
--
ALTER TABLE `insurance_nominees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insurance_payments`
--
ALTER TABLE `insurance_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `policies`
--
ALTER TABLE `policies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `policy_pricings`
--
ALTER TABLE `policy_pricings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `policy_sub_types`
--
ALTER TABLE `policy_sub_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `policy_types`
--
ALTER TABLE `policy_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `super_admin_settings`
--
ALTER TABLE `super_admin_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_company_details`
--
ALTER TABLE `user_company_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `claims`
--
ALTER TABLE `claims`
  ADD CONSTRAINT `claims_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `claims_insurance_id_foreign` FOREIGN KEY (`insurance_id`) REFERENCES `insurances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `claims_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `claim_documents`
--
ALTER TABLE `claim_documents`
  ADD CONSTRAINT `claim_documents_claim_id_foreign` FOREIGN KEY (`claim_id`) REFERENCES `claims` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `claim_documents_document_type_id_foreign` FOREIGN KEY (`document_type_id`) REFERENCES `document_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `document_types`
--
ALTER TABLE `document_types`
  ADD CONSTRAINT `document_types_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `domains`
--
ALTER TABLE `domains`
  ADD CONSTRAINT `domains_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `durations`
--
ALTER TABLE `durations`
  ADD CONSTRAINT `durations_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `insurances`
--
ALTER TABLE `insurances`
  ADD CONSTRAINT `insurances_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `insurances_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `insurances_policy_id_foreign` FOREIGN KEY (`policy_id`) REFERENCES `policies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `insurances_policy_pricing_id_foreign` FOREIGN KEY (`policy_pricing_id`) REFERENCES `policy_pricings` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `insurances_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `insurance_documents`
--
ALTER TABLE `insurance_documents`
  ADD CONSTRAINT `insurance_documents_document_type_id_foreign` FOREIGN KEY (`document_type_id`) REFERENCES `document_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `insurance_documents_insurance_id_foreign` FOREIGN KEY (`insurance_id`) REFERENCES `insurances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `insurance_installments`
--
ALTER TABLE `insurance_installments`
  ADD CONSTRAINT `insurance_installments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `insurance_installments_insurance_id_foreign` FOREIGN KEY (`insurance_id`) REFERENCES `insurances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `insurance_installments_policy_id_foreign` FOREIGN KEY (`policy_id`) REFERENCES `policies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `insurance_insureds`
--
ALTER TABLE `insurance_insureds`
  ADD CONSTRAINT `insurance_insureds_insurance_id_foreign` FOREIGN KEY (`insurance_id`) REFERENCES `insurances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `insurance_nominees`
--
ALTER TABLE `insurance_nominees`
  ADD CONSTRAINT `insurance_nominees_insurance_id_foreign` FOREIGN KEY (`insurance_id`) REFERENCES `insurances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `insurance_payments`
--
ALTER TABLE `insurance_payments`
  ADD CONSTRAINT `insurance_payments_installment_id_foreign` FOREIGN KEY (`installment_id`) REFERENCES `insurance_installments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `insurance_payments_insurance_id_foreign` FOREIGN KEY (`insurance_id`) REFERENCES `insurances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `policies`
--
ALTER TABLE `policies`
  ADD CONSTRAINT `policies_claim_document_type_id_foreign` FOREIGN KEY (`claim_document_type_id`) REFERENCES `document_types` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `policies_policy_document_type_id_foreign` FOREIGN KEY (`policy_document_type_id`) REFERENCES `document_types` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `policies_policy_sub_type_id_foreign` FOREIGN KEY (`policy_sub_type_id`) REFERENCES `policy_sub_types` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `policies_policy_type_id_foreign` FOREIGN KEY (`policy_type_id`) REFERENCES `policy_types` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `policies_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `policies_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `policies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `policy_pricings`
--
ALTER TABLE `policy_pricings`
  ADD CONSTRAINT `policy_pricings_duration_id_foreign` FOREIGN KEY (`duration_id`) REFERENCES `durations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `policy_pricings_policy_id_foreign` FOREIGN KEY (`policy_id`) REFERENCES `policies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `policy_sub_types`
--
ALTER TABLE `policy_sub_types`
  ADD CONSTRAINT `policy_sub_types_policy_type_id_foreign` FOREIGN KEY (`policy_type_id`) REFERENCES `policy_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `policy_sub_types_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `policy_types`
--
ALTER TABLE `policy_types`
  ADD CONSTRAINT `policy_types_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `taxes`
--
ALTER TABLE `taxes`
  ADD CONSTRAINT `taxes_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_created_by_id_foreign` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `users_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_company_details`
--
ALTER TABLE `user_company_details`
  ADD CONSTRAINT `user_company_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
