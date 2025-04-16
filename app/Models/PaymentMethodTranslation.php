<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodTranslation extends Model
{
    public $fillable = ['payment_method_id', 'name', 'locale'];
}
