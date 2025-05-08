<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use YlsIdeas\FeatureFlags\Facades\Features;

class AddedPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            "View Sales Areas",
            "Create Sales Areas",
            "Edit Sales Areas",
            "Delete Sales Areas",

            "View Client Suppliers",
            "Create Client Suppliers",
            "Edit Client Suppliers",
            "Delete Client Suppliers",

            "View Goods",
            "Create Goods",
            "Edit Goods",
            "Delete Goods",

            "View Jobs",
            "Create Jobs",
            "Edit Jobs",
            "Delete Jobs",

            "View Payment Methods",
            "Create Payment Methods",
            "Edit Payment Methods",
            "Delete Payment Methods",

            "View Client Types",
            "Create Client Types",
            "Edit Client Types",
            "Delete Client Types",

            "View Sailing Boats",
            "Create Sailing Boats",
            "Edit Sailing Boats",
            "Delete Sailing Boats",

            "View Goods Suppliers",
            "Create Goods Suppliers",
            "Edit Goods Suppliers",
            "Delete Goods Suppliers",

            "View Expenses Types",
            "Create Expenses Types",
            "Edit Expenses Types",
            "Delete Expenses Types",

            "View Experience Types",
            "Create Experience Types",
            "Edit Experience Types",
            "Delete Experience Types",

            "View Clients",
            "Create Clients",
            "Edit Clients",
            "Delete Clients",

            "View FeedBacks",
            "Create FeedBacks",
            "Edit FeedBacks",
            "Delete FeedBacks",

            "View Bookings",
            "Create Bookings",
            "Edit Bookings",
            "Delete Bookings",

            "Create Booking Groups",
            "Edit Booking Groups",
            "Delete Booking Groups",

            "View Extra Services",
            "Create Extra Services",
            "Edit Extra Services",
            "Delete Extra Services",

            "View Booking Extra Services",
            "Create Booking Extra Services",
            "Edit Booking Extra Services",
            "Delete Booking Extra Services",

            'View Employee Types',
            'Create Employee Types',
            'Edit Employee Types',
            'Delete Employee Types',

            'View Employee Nationalities',
            'Create Employee Nationalities',
            'Edit Employee Nationalities',
            'Delete Employee Nationalities',

            'View Employee Religions',
            'Create Employee Religions',
            'Edit Employee Religions',
            'Delete Employee Religions',

            'View Employee Marital Status',
            'Create Employee Marital Status',
            'Edit Employee Marital Status',
            'Delete Employee Marital Status',

            'View Employee Identity Types',
            'Create Employee Identity Types',
            'Edit Employee Identity Types',
            'Delete Employee Identity Types',

            'View Employee Card Issuers',
            'Create Employee Card Issuers',
            'Edit Employee Card Issuers',
            'Delete Employee Card Issuers',

            "View Employees",
            "Create Employees",
            "Edit Employees",
            "Delete Employees",

            // "View Account Types",
            // "Create Account Types",
            // "Edit Account Types",
            // "Delete Account Types",

            // "View Accounts",
            // "Create Accounts",
            // "Edit Accounts",
            // "Delete Accounts",

            "View Expenses",
            "Create Expenses",
            "Edit Expenses",
            "Delete Expenses",

            "View Car Suppliers",
            "Create Car Suppliers",
            "Edit Car Suppliers",
            "Delete Car Suppliers",

            "View Car Contracts",
            "Create Car Contracts",
            "Edit Car Contracts",
            "Delete Car Contracts",

            "View Car Expenses",
            "Create Car Expenses",
            "Edit Car Expenses",
            "Delete Car Expenses",

            "View Car Tasks",
            "Create Car Tasks",
            "Edit Car Tasks",
            "Delete Car Tasks",

            "View Detailed Clients Report",
            "View Clients Report",
            "View Client Suppliers Report",
            "View Booking Groups Report",
            "View Extra Services Report",
            "View Credit Sales Bookings Report",
            "View Expenses Report",
            "View Trip Analysis Report",
            "View Trip Analysis By Sales Area Report",
            "View Car Expenses Report",
            "View Car Income Report",
            "View Car Income Expenses Report",
            "View Car Contracts Due Amount Report",


            "View Account tree",
            "Create Account tree",
            "Edit Account tree",
            "Delete Account tree",

            "View Restrictions",
            "Create Restrictions",
            "Edit Restrictions",
            "Delete Restrictions",

            "View Financial reports",
            "Create Financial reports",
            "Edit Financial reports",
            "Delete Financial reports",

            "View Warhouse Management",
            "Create Warhouse Management",
            "Edit Warhouse Management",
            "Delete Warhouse Management",


        ];

        $group_id = [
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            2,
            5,
            5,
            5,
            5,
            5,
            5,
            5,
            5,
            6,
            6,
            6,
            6,
            6,
            6,
            6,
            7,
            7,
            7,
            7,
            7,
            7,
            7,
            7,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            9,
            // 8, 8, 8, 8,
            // 8, 8, 8, 8,
            8,
            8,
            8,
            8,
            10,
            10,
            10,
            10,
            10,
            10,
            10,
            10,
            10,
            10,
            10,
            10,
            10,
            10,
            10,
            10,
            11,
            11,
            11,
            11,
            11,
            11,
            11,
            11,
            11,
            11,
            11,
            11,
            11,
            12,
            12,
            12,
            12,
            13,
            13,
            13,
            13,
            14,
            14,
            14,
            14,
            15,
            15,
            15,
            15,
        ];

        if (Features::accessible('track-financials-feature')) {
            $array = [
                "View Track Financials Report",
            ];
            $group_id_array = [
                5
            ];
            $permissions = array_merge($permissions, $array);
            $group_id = array_merge($group_id, $group_id_array);
        }

        $guards = config()->get('permission.guards');

        foreach ($guards as $key => $guard) {
            foreach ($permissions as $permission_key => $permission) {
                $row = Permission::updateOrCreate([
                    'name' => $permission,
                    'guard_name' => $guard
                ], [
                    'name' => $permission,
                    'permission_group_id' => $group_id[$permission_key]
                ]);
            }
        }
    }
}
