<?php

namespace Modules\AccountingDepartment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\AccountingDepartment\App\Models\ChartOfAccount;
use Modules\AccountingDepartment\Models\ChartOfAccount as ModelsChartOfAccount;

class ChartOfAccountsSeeder extends Seeder
{
    public function run()
    {
        $accounts = [
            [
                'id' => 1,
                'account_name' => 'الاصول',
                'account_number' => '1',
                'parent_id' => null,
                'created_at' => '2025-04-09 07:02:20',
                'updated_at' => '2025-04-09 07:02:20'
            ],
            [
                'id' => 2,
                'account_name' => 'الإلتزامات وصافي الأصول',
                'account_number' => '2',
                'parent_id' => null,
                'created_at' => '2025-04-09 07:04:22',
                'updated_at' => '2025-04-09 07:04:22'
            ],
            [
                'id' => 3,
                'account_name' => 'الإيرادات والتبرعات',
                'account_number' => '3',
                'parent_id' => null,
                'created_at' => '2025-04-09 07:05:00',
                'updated_at' => '2025-04-09 07:05:00'
            ],
            [
                'id' => 4,
                'account_name' => 'المصروفات',
                'account_number' => '4',
                'parent_id' => null,
                'created_at' => '2025-04-09 07:05:55',
                'updated_at' => '2025-04-09 07:05:55'
            ],
            [
                'id' => 5,
                'account_name' => 'الاصول المتداوله',
                'account_number' => '11',
                'parent_id' => '1',
                'created_at' => '2025-04-09 07:06:25',
                'updated_at' => '2025-04-09 07:06:25'
            ],
            [
                'id' => 6,
                'account_name' => 'الاصول غير المتداوله',
                'account_number' => '12',
                'parent_id' => '1',
                'created_at' => '2025-04-09 07:07:08',
                'updated_at' => '2025-04-09 07:07:08'
            ],
            [
                'id' => 7,
                'account_name' => 'اصول الاوقاف',
                'account_number' => '13',
                'parent_id' => '1',
                'created_at' => '2025-04-09 07:07:25',
                'updated_at' => '2025-04-09 07:07:25'
            ],
            [
                'id' => 8,
                'account_name' => 'النقدية وما في حكمها',
                'account_number' => '111',
                'parent_id' => '5',
                'created_at' => '2025-04-09 07:07:52',
                'updated_at' => '2025-04-09 07:07:52'
            ],
            [
                'id' => 9,
                'account_name' => 'نقدية وودائع في البنوك',
                'account_number' => '1111',
                'parent_id' => '8',
                'created_at' => '2025-04-09 07:08:23',
                'updated_at' => '2025-04-09 07:08:23'
            ],
            [
                'id' => 10,
                'account_name' => 'حسابات جارية - مصرف الراجحي',
                'account_number' => '11111',
                'parent_id' => '9',
                'created_at' => '2025-04-09 07:08:54',
                'updated_at' => '2025-04-09 07:08:54'
            ],
            [
                'id' => 11,
                'account_name' => 'مصرف الراجحي-فرع السادة- ح/العام 510000',
                'account_number' => '111111',
                'parent_id' => '10',
                'created_at' => '2025-04-09 07:10:21',
                'updated_at' => '2025-04-09 07:10:21'
            ],
            [
                'id' => 12,
                'account_name' => 'احد',
                'account_number' => '121',
                'parent_id' => '6',
                'created_at' => '2025-04-09 07:11:31',
                'updated_at' => '2025-04-09 07:11:31'
            ],
            [
                'id' => 13,
                'account_name' => 'ءئؤ',
                'account_number' => '6548',
                'parent_id' => '12',
                'created_at' => '2025-04-09 07:15:10',
                'updated_at' => '2025-04-09 07:15:10'
            ],
        ];

        foreach ($accounts as $account) {
            ModelsChartOfAccount::create($account);
        }
    }
}