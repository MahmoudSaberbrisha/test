<?php

namespace app\Models\Stocks\Rasid;

use Illuminate\Database\Eloquent\Model;
use app\Models\Stocks\Setting\StoreBranchSetting;
use App\Models\User;

class StoreMasrofAsnafFar3 extends Model
{
    protected $table = 'store_masrof_asnaf_far3';

    protected $fillable = [
        'main_branch_fk',
        'sub_branch_fk',
        'sarf_rkm',
        'sarf_to',
        'sanf_code',
        'available_amount',
        'sanf_amount',
        'one_price_sell',
        'date',
        'date_ar',
        'publisher',
        'publisher_name'
    ];

    protected $casts = [
        'main_branch_fk' => 'integer',
        'sub_branch_fk' => 'integer',
        'sarf_rkm' => 'integer',
        'sarf_to' => 'integer',
        'sanf_code' => 'integer',
        'available_amount' => 'integer',
        'sanf_amount' => 'integer',
        'one_price_sell' => 'integer',
        'date' => 'integer',
        'publisher' => 'integer',
    ];

    public $timestamps = false;

    /**
     * Get the main branch associated with the record.
     */
    public function mainBranch()
    {
        return $this->belongsTo(StoreBranchSetting::class, 'main_branch_fk');
    }

    /**
     * Get the sub branch associated with the record.
     */
    public function subBranch()
    {
        return $this->belongsTo(StoreBranchSetting::class, 'sub_branch_fk');
    }

    /**
     * Get the publisher user associated with the record.
     */
    public function publisherUser()
    {
        return $this->belongsTo(User::class, 'publisher');
    }
}
