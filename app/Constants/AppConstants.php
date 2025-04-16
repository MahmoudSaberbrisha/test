<?php

namespace App\Constants;
use YlsIdeas\FeatureFlags\Facades\Features;

class AppConstants
{
    public static function init()
    {
        if (Features::accessible('regions-branches-feature')) {
            if (!defined('SUPER_ADMIN_ROLE_ID')) {
                define('SUPER_ADMIN_ROLE_ID', 1);
            }
            if (!defined('REGION_ADMIN_ROLE_ID')) {
                define('REGION_ADMIN_ROLE_ID', 2);
            }
            if (!defined('BRANCH_ADMIN_ROLE_ID')) {
                define('BRANCH_ADMIN_ROLE_ID', 3);
            }
            if (!defined('BASIC_ROLES_IDs')) {
                define('BASIC_ROLES_IDs', [1, 2, 3]);
            }
            if (!defined('UPPER_ROLES_IDs')) {
                define('UPPER_ROLES_IDs', [1, 2]);
            }
        }

        if (Features::accessible('branches-feature')) {
            if (!defined('SUPER_ADMIN_ROLE_ID')) {
                define('SUPER_ADMIN_ROLE_ID', 1);
            }
            if (!defined('UPPER_ROLES_IDs')) {
                define('UPPER_ROLES_IDs', [1]);
            }
            if (!defined('BASIC_ROLES_IDs')) {
                define('BASIC_ROLES_IDs', [1, 2]);
            }
        }

        if (!defined('WEEK_DAYES')) {
            define('WEEK_DAYES', [ 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']);
        }
        if (!defined('DISCOUNT_TYPES')) {
            define('DISCOUNT_TYPES', [ 'percentage' => 'Percentage', 'fixed' => 'Fixed']);
        }
        if (!defined('BOOKING_TYPES')) {
            define('BOOKING_TYPES', ['group' => 'Group', 'private' => 'Private']);
        }
    }
}
