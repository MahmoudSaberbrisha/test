<?php

namespace App\Models\Stocks\Purchase;

use Illuminate\Database\Eloquent\Model;
use App\Models\Stocks\Setting\StoreBranchSetting;
use App\Models\Stocks\Other\StoreOtherSupplier;
use App\Models\User;

class StoreHadbackPurchase extends Model
{
    protected $table = 'store_hadback_purchases';

    protected $fillable = [
        'main_branch_id_fk',
        'sub_branch_id_fk',
        'supplier_code',
        'fatora_code',
        'product_code',
        'amount_buy',
        'all_cost_buy',
        'one_price_sell',
        'hadback_amount',
        'date',
        'date_s',
        'publisher',
    ];

    protected $casts = [
        'main_branch_id_fk' => 'integer',
        'sub_branch_id_fk' => 'integer',
        'supplier_code' => 'integer',
        'fatora_code' => 'integer',
        'product_code' => 'string',
        'hadback_amount' => 'integer',
        'date' => 'integer',
        'date_s' => 'integer',
        'publisher' => 'integer',
    ];

    public $timestamps = false;

    /**
     * Get the main branch associated with the hadback purchase.
     */
    public function mainBranch()
    {
        return $this->belongsTo(StoreBranchSetting::class, 'main_branch_id_fk');
    }

    /**
     * Get the sub branch associated with the hadback purchase.
     */
    public function subBranch()
    {
        return $this->belongsTo(StoreBranchSetting::class, 'sub_branch_id_fk');
    }

    /**
     * Get the supplier associated with the hadback purchase.
     */
    public function supplier()
    {
        return $this->belongsTo(StoreOtherSupplier::class, 'supplier_code');
    }

    /**
     * Get the publisher user associated with the hadback purchase.
     */
    public function publisherUser()
    {
        return $this->belongsTo(User::class, 'publisher');
    }
}
