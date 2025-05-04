<?php

namespace App\Models\Stocks\Other;

use Illuminate\Database\Eloquent\Model;

class StoreOtherSupplier extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'store_other_suppliers';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'code';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'int';

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
        'code',
        'name',
        'supplier_address',
        'supplier_phone',
        'supplier_fax',
        'accountant_name',
        'accountant_telephone',
        'supplier_dayen'
    ];

    protected $casts = [
        'code' => 'integer',
        'supplier_dayen' => 'decimal:2',
    ];
}
