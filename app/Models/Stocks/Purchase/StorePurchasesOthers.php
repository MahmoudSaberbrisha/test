<?php

namespace app\Models\Stocks\Purchase;

use Illuminate\Database\Eloquent\Model;
use app\Models\Stocks\Setting\StoreBranchSetting;

class StorePurchasesOthers extends Model
{
    protected $table = 'store_purchases_others';

    protected $fillable = [
        'fatora_code',
        'main_branch_id_fk',
        'sub_branch_id_fk',
        'product_code',
        'product_name',
        'amount_buy',
        'all_cost_buy',
        'one_price_sell',
        'one_price_buy',
        'rasid_motah',
        'date_s',
        'date_ar',
        'publisher',
        'had_back',
        'had_back_date',
        'had_back_amount',
        'old',
        'approved',
    ];

    protected $casts = [
        'main_branch_id_fk' => 'integer',
        'sub_branch_id_fk' => 'integer',
        'one_price_buy' => 'decimal:2',
        'rasid_motah' => 'decimal:2',
        'date_s' => 'integer',
        'old' => 'boolean',
    ];

    public $timestamps = false;

    /**
     * Get the main branch associated with the purchase.
     */
    public function mainBranch()
    {
        return $this->belongsTo(StoreBranchSetting::class, 'main_branch_id_fk');
    }

    /**
     * Get the sub branch associated with the purchase.
     */
    public function subBranch()
    {
        return $this->belongsTo(StoreBranchSetting::class, 'sub_branch_id_fk');
    }
}
