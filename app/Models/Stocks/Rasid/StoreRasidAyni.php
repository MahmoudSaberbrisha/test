<?php

namespace app\Models\Stocks\Rasid;

use Illuminate\Database\Eloquent\Model;
use app\Models\Stocks\Setting\StoreBranchSetting;
use app\Models\Stocks\Items\StoreItem;
use App\Models\User;

class StoreRasidAyni extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'store_rasid_ayni';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'main_branch_id_fk',
        'sub_branch_id_fk',
        'date',
        'date_ar',
        'publisher_name',
        'publisher',
        'sanf_code',
        'sanf_id',
        'sanf_name',
        'sanf_amount'
    ];

    public function mainBranch()
    {
        return $this->belongsTo(StoreBranchSetting::class, 'main_branch_id_fk');
    }

    public function subBranch()
    {
        return $this->belongsTo(StoreBranchSetting::class, 'sub_branch_id_fk');
    }

    public function publisherUser()
    {
        return $this->belongsTo(User::class, 'publisher');
    }

    public function item()
    {
        return $this->belongsTo(StoreItem::class, 'sanf_code', 'sanf_code');
    }
}
