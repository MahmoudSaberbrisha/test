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
                'account_name' => 'أصول',
                'account_number' => '1',
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'account_name' => 'الخصوم وصافي الأصول',
                'account_number' => '2',
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],


            [
                'id' => 4,
                'account_name' => 'المصروفات',
                'account_number' => '4',
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 5,
                'account_name' => 'الأصول المتداولة',
                'account_number' => '11',
                'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 6,
                'account_name' => 'الأصول غير المتداولة',
                'account_number' => '12',
                'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 7,
                'account_name' => 'أصول الأوقاف',
                'account_number' => '13',
                'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 8,
                'account_name' => 'النقدية وما في حكمها',
                'account_number' => '111',
                'parent_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 9,
                'account_name' => 'المحافظ الإقراضية والتمويلة',
                'account_number' => '112',
                'parent_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 10,
                'account_name' => 'الإستثمارات ( المتداولة )',
                'account_number' => '113',
                'parent_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 11,
                'account_name' => 'الذمم المدينة',
                'account_number' => '114',
                'parent_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 12,
                'account_name' => 'مصروفات مدفوعة مقدماً',
                'account_number' => '115',
                'parent_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 13,
                'account_name' => 'إيرادات وتبرعات مستحقة',
                'account_number' => '116',
                'parent_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 14,
                'account_name' => 'المخزون',
                'account_number' => '117',
                'parent_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 15,
                'account_name' => 'الحسابات الجارية للفروع "أطراف ذات علاقة"',
                'account_number' => '118',
                'parent_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'id' => 16,
                'account_name' => 'الأصول الثابتة',
                'account_number' => '121',
                'parent_id' => 6,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 17,
                'account_name' => 'الأصول غير الملموسة',
                'account_number' => '122',
                'parent_id' => 6,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 18,
                'account_name' => 'الإستثمارات ( غير المتداولة )',
                'account_number' => '123',
                'parent_id' => 6,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 19,
                'account_name' => 'أعمال رأسمالية تحت الإنشاء "مشاريع تحت التنفيذ"',
                'account_number' => '124',
                'parent_id' => 6,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 20,
                'account_name' => 'الموجودات الحيوية',
                'account_number' => '125',
                'parent_id' => 6,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 21,
                'account_name' => 'النقدية الموقوفة',
                'account_number' => '131',
                'parent_id' => 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 22,
                'account_name' => 'محافظ إقراضية وتمويلية موقوفة',
                'account_number' => '132',
                'parent_id' => 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 23,
                'account_name' => 'الإستثمارات الوقفية',
                'account_number' => '133',
                'parent_id' => 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 24,
                'account_name' => 'الأصول الثابتة الوقفية',
                'account_number' => '134',
                'parent_id' => 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 25,
                'account_name' => 'الأصول غير الملموسة - أوقاف',
                'account_number' => '135',
                'parent_id' => 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 26,
                'account_name' => 'أعمال رأسمالية تحت الإنشاء "مشاريع وقفية تحت التنفيذ"',
                'account_number' => '136',
                'parent_id' => 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 27,
                'account_name' => 'الموجودات الحيوية - أوقاف',
                'account_number' => '137',
                'parent_id' => 7,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 28,
                'account_name' => 'نقدية وودائع في البنوك',
                'account_number' => '11101',
                'parent_id' => 8,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 29,
                'account_name' => 'حساب ودائع قصيرة الأجل',
                'account_number' => '11102',
                'parent_id' => 8,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 30,
                'account_name' => 'الصندوق العام',
                'account_number' => '11103',
                'parent_id' => 8,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 31,
                'account_name' => 'النقدية في الطريق "شيكات تحت التحصيل"',
                'account_number' => '11104',
                'parent_id' => 8,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 32,
                'account_name' => 'مح افظ إقراضية تمويلية',
                'account_number' => '11201',
                'parent_id' => 9,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 33,
                'account_name' => 'الإستثمارات ( المتداولة )',
                'account_number' => '11301',
                'parent_id' => 10,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 34,
                'account_name' => 'ذمم مدينة - موظفين "عاملين"',
                'account_number' => '11401',
                'parent_id' => 11,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 35,
                'account_name' => 'ذمم مدينة - عملاء',
                'account_number' => '11402',
                'parent_id' => 11,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 36,
                'account_name' => 'ذمم مدينة - دفعات مقدمة',
                'account_number' => '11403',
                'parent_id' => 11,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 37,
                'account_name' => 'ذمم مدينة أخرى',
                'account_number' => '11404',
                'parent_id' => 11,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 38,
                'account_name' => 'ذمم مدينة - ضريبة القيمة المضافة (مدخلات)',
                'account_number' => '11405',
                'parent_id' => 11,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 39,
                'account_name' => 'مصاريف عمومية وإدارية مدفوعة مقدماً',
                'account_number' => '11501',
                'parent_id' => 12,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 40,
                'account_name' => 'مصاريف جمع الأموال المدفوعة مقدماً',
                'account_number' => '11502',
                'parent_id' => 12,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 41,
                'account_name' => 'مصاريف التشغيل المحملة على البرامج والانشطة المقدمة',
                'account_number' => '11503',
                'parent_id' => 12,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 42,
                'account_name' => 'مصاريف الحوكمة المقدمة',
                'account_number' => '11504',
                'parent_id' => 12,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 43,
                'account_name' => 'ايرادات وتبرعات مقيدة - مستحقة',
                'account_number' => '11601',
                'parent_id' => 13,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 44,
                'account_name' => 'ايرادات وتبرعات غير مقيدة - مستحقة',
                'account_number' => '11602',
                'parent_id' => 13,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 45,
                'account_name' => 'ايرادات وتبرعات اوقاف - مستحقة',
                'account_number' => '11603',
                'parent_id' => 13,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 46,
                'account_name' => 'مخزون مستهلكات',
                'account_number' => '11701',
                'parent_id' => 14,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 47,
                'account_name' => 'مخزون بضائع ومنتجات جاهزة',
                'account_number' => '11702',
                'parent_id' => 14,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 48,
                'account_name' => 'مخزون مواد خام',
                'account_number' => '11703',
                'parent_id' => 14,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 49,
                'account_name' => 'مخزون تحت التشغيل "قيد التصنيع"',
                'account_number' => '11704',
                'parent_id' => 14,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 50,
                'account_name' => 'الحسابات الجارية للفروع "أطراف ذات علاقة"',
                'account_number' => '11801',
                'parent_id' => 15,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 51,
                'account_name' => 'الأراضي',
                'account_number' => '12101',
                'parent_id' => 16,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 52,
                'account_name' => 'المباني',
                'account_number' => '12102',
                'parent_id' => 16,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 53,
                'account_name' => 'آلات ومعدات',
                'account_number' => '12103',
                'parent_id' => 16,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 54,
                'account_name' => 'السيارات',
                'account_number' => '12104',
                'parent_id' => 16,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 55,
                'account_name' => 'الأثاث المكتبي',
                'account_number' => '12105',
                'parent_id' => 16,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 56,
                'account_name' => 'الات ومعدات مكتبية',
                'account_number' => '12106',
                'parent_id' => 16,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 57,
                'account_name' => 'عدد وأدوات',
                'account_number' => '12107',
                'parent_id' => 16,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 58,
                'account_name' => 'أدوات وأجهزة التصوير والعرض',
                'account_number' => '12108',
                'parent_id' => 16,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 59,
                'account_name' => 'أجهزة الاتصال والأمن والحماية',
                'account_number' => '12109',
                'parent_id' => 16,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 60,
                'account_name' => 'أجهزة الحاسب الالي وملحقاتها',
                'account_number' => '12110',
                'parent_id' => 16,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 61,
                'account_name' => 'اجهزة التدفئة والتبريد والتهوية',
                'account_number' => '12111',
                'parent_id' => 16,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 62,
                'account_name' => 'لوحات الدعاية والإعلان',
                'account_number' => '12112',
                'parent_id' => 16,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 63,
                'account_name' => 'الأصول غير الملموسة',
                'account_number' => '12201',
                'parent_id' => 17,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 79,
                'account_name' => 'مجمع الإهلاك - للأصول الوقفية',
                'account_number' => '22504',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 80,
                'account_name' => 'مجمع استنفاذ - للموجودات الحيوية',
                'account_number' => '22505',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 81,
                'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة',
                'account_number' => '22506',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 82,
                'account_name' => 'مجمع استنفاذ - للأصول الثابتة',
                'account_number' => '22507',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 83,
                'account_name' => 'مجمع استنفاذ - للأصول الوقفية',
                'account_number' => '22508',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 84,
                'account_name' => 'مجمع استنفاذ - للأصول الحيوية',
                'account_number' => '22509',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 85,
                'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة',
                'account_number' => '22510',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 86,
                'account_name' => 'مجمع استنفاذ - للأصول الثابتة',
                'account_number' => '22511',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 87,
                'account_name' => 'مجمع استنفاذ - للأصول الوقفية',
                'account_number' => '22512',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 88,
                'account_name' => 'مجمع استنفاذ - للأصول الحيوية',
                'account_number' => '22513',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 89,
                'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة',
                'account_number' => '22514',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 90,
                'account_name' => 'مجمع استنفاذ - للأصول الثابتة',
                'account_number' => '22515',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 91,
                'account_name' => 'مجمع استنفاذ - للأصول الوقفية',
                'account_number' => '22516',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 92,
                'account_name' => 'مجمع استنفاذ - للأصول الحيوية',
                'account_number' => '22517',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 93,
                'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة',
                'account_number' => '22518',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [

                'id' => 94,
                'account_name' => 'مجمع استنفاذ - للأصول الثابتة',
                'account_number' => '22519',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 95,
                'account_name' => 'مجمع استنفاذ - للأصول الوقفية',
                'account_number' => '22520',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 96,
                'account_name' => 'مجمع استنفاذ - للأصول الحيوية',
                'account_number' => '22521',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 97,
                'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة',
                'account_number' => '22522',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 98,
                'account_name' => 'مجمع استنفاذ - للأصول الثابتة',
                'account_number' => '22523',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 99,
                'account_name' => 'مجمع استنفاذ - للأصول الوقفية',
                'account_number' => '22524',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 100,
                'account_name' => 'مجمع استنفاذ - للأصول الحيوية',
                'account_number' => '22525',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 101,
                'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة',
                'account_number' => '22526',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 102,
                'account_name' => 'مجمع استنفاذ - للأصول الثابتة',
                'account_number' => '22527',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 103,
                'account_name' => 'مجمع استنفاذ - للأصول الوقفية',
                'account_number' => '22528',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 104,
                'account_name' => 'مجمع استنفاذ - للأصول الحيوية',
                'account_number' => '22529',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 105,
                'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة',
                'account_number' => '22530',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 106,
                'account_name' => 'مجمع استنفاذ - للأصول الثابتة',
                'account_number' => '22531',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 107,
                'account_name' => 'مجمع استنفاذ - للأصول الوقفية',
                'account_number' => '22532',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 108,
                'account_name' => 'مجمع استنفاذ - للأصول الحيوية',
                'account_number' => '22533',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 109,
                'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة',
                'account_number' => '22534',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 110,
                'account_name' => 'مجمع استنفاذ - للأصول الثابتة',
                'account_number' => '22535',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 111,
                'account_name' => 'مجمع استنفاذ - للأصول الوقفية',
                'account_number' => '22536',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 112,
                'account_name' => 'مجمع استنفاذ - للأصول الحيوية',
                'account_number' => '22537',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 113,
                'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة',
                'account_number' => '22538',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 114,
                'account_name' => 'مجمع استنفاذ - للأصول الثابتة',
                'account_number' => '22539',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 115,
                'account_name' => 'مجمع استنفاذ - للأصول الوقفية',
                'account_number' => '22540',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [

                'id' => 116,
                'account_name' => 'مجمع استنفاذ - للأصول الحيوية',
                'account_number' => '22541',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 117,
                'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة',
                'account_number' => '22542',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 118,
                'account_name' => 'مجمع استنفاذ - للأصول الثابتة',
                'account_number' => '22543',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 119,
                'account_name' => 'مجمع استنفاذ - للأصول الوقفية',
                'account_number' => '22544',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 120,
                'account_name' => 'مجمع استنفاذ - للأصول الحيوية',
                'account_number' => '22545',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 121,
                'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة',
                'account_number' => '22546',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 122,
                'account_name' => 'مجمع استنفاذ - للأصول الثابتة',
                'account_number' => '22547',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 123,
                'account_name' => 'مجمع استنفاذ - للأصول الوقفية',
                'account_number' => '22548',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 124,
                'account_name' => 'مجمع استنفاذ - للأصول الحيوية',
                'account_number' => '22549',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 125,
                'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة',
                'account_number' => '22550',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],



            [
                'id' => 126,
                'account_name' => 'مجمع استنفاذ - للأصول الثابتة',
                'account_number' => '22551',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 127,
                'account_name' => 'مجمع استنفاذ - للأصول الوقفية',
                'account_number' => '22552',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 128,
                'account_name' => 'مجمع استنفاذ - للأصول الحيوية',
                'account_number' => '22553',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 129,
                'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة',
                'account_number' => '22554',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 130,
                'account_name' => 'مجمع استنفاذ - للأصول الثابتة',
                'account_number' => '22555',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 131,
                'account_name' => 'مجمع استنفاذ - للأصول الوقفية',
                'account_number' => '22556',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 132,
                'account_name' => 'مجمع استنفاذ - للأصول الحيوية',
                'account_number' => '22557',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 133,
                'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة',
                'account_number' => '22558',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 134,
                'account_name' => 'مجمع استنفاذ - للأصول الثابتة',
                'account_number' => '22559',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 135,
                'account_name' => 'مجمع استنفاذ - للأصول الوقفية',
                'account_number' => '22560',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 136,
                'account_name' => 'مجمع استنفاذ - للأصول الحيوية',
                'account_number' => '22561',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 137,
                'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة',
                'account_number' => '22562',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 138,
                'account_name' => 'مجمع استنفاذ - للأصول الثابتة',
                'account_number' => '22563',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 139,
                'account_name' => 'مجمع استنفاذ - للأصول الوقفية',
                'account_number' => '22564',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 140,
                'account_name' => 'مجمع استنفاذ - للأصول الحيوية',
                'account_number' => '22565',
                'parent_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],

            ['id' => 142, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22566', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 143, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22567', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 144, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22568', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 145, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22569', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 146, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22570', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 147, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22571', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 148, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22572', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 149, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22573', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 150, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22574', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 151, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22575', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 152, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22576', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 153, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22577', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 154, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22578', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 155, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22579', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 156, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22580', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 157, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22581', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 158, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22582', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 159, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22583', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 160, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22584', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 161, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22585', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 162, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22586', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 163, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22587', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 164, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22588', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 165, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22589', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 166, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22590', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 167, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22591', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 168, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22592', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 169, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22593', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 170, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22594', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 171, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22595', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 172, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22596', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 173, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22597', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 174, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22598', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 175, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22599', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 176, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22600', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 177, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22601', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 178, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22602', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 179, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22603', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 180, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22604', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 181, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22605', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 182, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22606', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 183, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22607', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 184, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22608', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 185, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22609', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 186, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22610', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 187, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22611', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 188, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22612', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 189, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22613', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 190, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22614', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 191, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22615', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 192, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22616', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 193, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22617', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 194, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22618', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 195, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22619', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 196, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22620', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 197, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22621', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 198, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22622', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 199, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22623', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 200, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22624', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 201, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22625', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 202, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22626', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 203, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22627', 'parent_id'  => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 204, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22628', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 205, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22629', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 206, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22630', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 207, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22631', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 208, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22632', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 209, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22633', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 210, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22634', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 211, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22635', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 212, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22636', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 213, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22637', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 214, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22638', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 215, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22639', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 216, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22640', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 217, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22641', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 218, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22642', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 219, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22643', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 220, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22644', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 221, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22645', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 222, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22646', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 223, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22647', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 224, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22648', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 225, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22649', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 226, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22650', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 227, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22651', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 228, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22652', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 229, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22653', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 230, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22654', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 231, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22655', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 232, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22656', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 233, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22657', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 235, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22659', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 236, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22660', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 237, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22661', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 238, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22662', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 239, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22663', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 240, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22664', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 241, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22665', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 242, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22666', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 243, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22667', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 244, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22668', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 245, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22669', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 246, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22670', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 247, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22671', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 248, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22672', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 249, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22673', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 250, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22674', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 251, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22675', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 252, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22676', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 253, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22677', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 254, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22678', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 255, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22679', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 256, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22680', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 257, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22681', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 258, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22682', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 259, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22683', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 260, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22684', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 261, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22685', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 262, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22686', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 263, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22687', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 264, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22688', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 265, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22689', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 266, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22690', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 267, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22691', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 268, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22692', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 269, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22693', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 270, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22694', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 271, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22695', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 272, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22696', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 273, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22697', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 274, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22698', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 275, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22699', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 276, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22700', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 277, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22701', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 278, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22702', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 279, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22703', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 280, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22704', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 281, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22705', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 282, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22706', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 283, 'account_name' => 'مجمع استنفاذ - للأصول الوقفية', 'account_number' => '22707', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 284, 'account_name' => 'مجمع استنفاذ - للأصول الحيوية', 'account_number' => '22708', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 285, 'account_name' => 'مجمع استنفاذ - للأصول غير الملموسة', 'account_number' => '22709', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 286, 'account_name' => 'مجمع استنفاذ - للأصول الثابتة', 'account_number' => '22710', 'parent_id' => 34, 'created_at' => now(), 'updated_at' => now()],
            [
                'id' => 469,
                'account_name' => 'التبرعات والايرادات',
                'account_number' => '3',
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 470,
                'account_name' => 'إيرادات',
                'account_number' => '31',
                'parent_id' => 469,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 471,
                'account_name' => 'إيرادات',
                'account_number' => '311',
                'parent_id' => 470,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 472,
                'account_name' => 'الزكاة',
                'account_number' => '31101',
                'parent_id' => 471,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 473,
                'account_name' => 'تبرعات وهبات مقيدة - نقدية',
                'account_number' => '31102',
                'parent_id' => 470,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Additional accounts would follow the same structure...
            [
                'id' => 533,
                'account_name' => 'تبرعات نقدية  لبناء أو شراء أوقاف',
                'account_number' => '31301',
                'parent_id' => 532,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 555,
                'account_name' => 'المصاريف العمومية والإدارية',
                'account_number' => '41',
                'parent_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 556,
                'account_name' => 'تكاليف العاملين / الموظفين',
                'account_number' => '411',
                'parent_id' => 555,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 557,
                'account_name' => 'الرواتب والأجور النقدية',
                'account_number' => '41101',
                'parent_id' => 556,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 558,
                'account_name' => 'الرواتب والأجور الاساسية',
                'account_number' => '41101001',
                'parent_id' => 557,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 559,
                'account_name' => 'بدل السكن',
                'account_number' => '41101002',
                'parent_id' => 557,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 560,
                'account_name' => 'بدل المواصلات',
                'account_number' => '41101003',
                'parent_id' => 557,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        foreach ($accounts as $account) {
            ModelsChartOfAccount::create($account);
        }
    }
}