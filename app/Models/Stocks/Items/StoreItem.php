<?php

namespace App\Models\Stocks\Items;

use Illuminate\Database\Eloquent\Model;
use App\Models\Stocks\Setting\StoreBranchSetting;

class StoreItem extends Model
{
    protected $table = 'store_item';

    protected $fillable = [
        'name',
        'sanf_code',
        'sanf_type',
        'main_branch_id_fk',
        'sub_branch_id_fk',
        'unit',
        'limit_order',
        'min_limit',
        'all_buy_cost',
        'all_amount',
        'one_buy_cost',
        'customer_price_sale',
        'first_balance_period',
        'past_amount',
        'cost_past_amount',
        'sanf_type_gym',
        'category',
    ];

    public $timestamps = false;

    public function mainBranch()
    {
        return $this->belongsTo(StoreBranchSetting::class, 'main_branch_id_fk');
    }

    public function subBranch()
    {
        return $this->belongsTo(StoreBranchSetting::class, 'sub_branch_id_fk');
    }

    public function getCategoryNameAttribute()
    {
        $categories = [
            1 => 'وحدات',
            2 => 'كراتين',
            3 => 'علب',
        ];

        return $categories[$this->category] ?? 'غير معروف';
    }
}
