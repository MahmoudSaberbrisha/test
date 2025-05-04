<?php

namespace App\Models\Stocks\Tahwelat;

use app\Models\Stocks\Items\StoreItem;
use App\Models\Stocks\Other\StoreOtherStorage;
use Illuminate\Database\Eloquent\Model;

class StoreTahwelatAsnaf extends Model
{
    protected $table = 'store_tahwelat_asnaf';

    protected $fillable = [
        'rkm_fk',
        'sanf_id',
        'sanf_n',
        'sanf_code',
        'amount_motah',
        'amount_send',
        'from_storage',
        'to_storage'
    ];

    protected $casts = [
        'rkm_fk' => 'integer',
        'sanf_id' => 'integer',
        'sanf_code' => 'integer',
        'amount_motah' => 'integer',
        'amount_send' => 'integer',
        'from_storage' => 'integer',
        'to_storage' => 'integer',
    ];

    public $timestamps = false;

    /**
     * Get the tahwelat record associated with this item.
     */
    public function tahwelat()
    {
        return $this->belongsTo(StoreTahwelat::class, 'rkm_fk');
    }

    /**
     * Get the store item associated with this record.
     */
    public function storeItem()
    {
        return $this->belongsTo(StoreItem::class, 'sanf_id');
    }

    /**
     * Get the from storage associated with the record.
     */
    public function fromStorage()
    {
        return $this->belongsTo(StoreOtherStorage::class, 'from_storage');
    }

    /**
     * Get the to storage associated with the record.
     */
    public function toStorage()
    {
        return $this->belongsTo(StoreOtherStorage::class, 'to_storage');
    }
}
